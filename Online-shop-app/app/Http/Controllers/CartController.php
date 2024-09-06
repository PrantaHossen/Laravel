<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\OrderDetails;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);

        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found'
            ]);
        }

        if (Cart::count() > 0) {
            // Check if this product is already in the cart
            $cartContent = Cart::content();
            $productAlreadyExist = false;

            foreach ($cartContent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                    break; // Exit the loop if the product is found
                }
            }

            if ($productAlreadyExist == false) {
                Cart::add($product->id, $product->name, 1, $product->price, [
                    'productImage' => (!empty($product->image) ? $product->image : '')
                ]);

                $status = true;
                $message = $product->name . ' added to cart';
            } else {
                $status = false;
                $message = $product->name . ' is already in the cart';
            }

        } else {
            // Cart is empty
            Cart::add($product->id, $product->name, 1, $product->price, [
                'productImage' => (!empty($product->image) ? $product->image : '')
            ]);

            $status = true;
            $message = $product->name . ' added to cart';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }


    public function cart(Request $request)
    {
        $cartContent = Cart::Content();
        $data['cartContent'] = $cartContent;
        return view('Front.cart', $data);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);

        $product = Product::find($itemInfo->id);

        //check qty available in stock

        if ($product->track_qty == 'Yes') {
            if ($qty <= $product->qty) {
                Cart::update($rowId, $qty);
                $message = 'cart updated Successfully';
                $status = true;
                session()->flash('success', $message);
            } else {
                $message = 'Requested quantity(' . $qty . ') not available in the stock';
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            Cart::update($rowId, $qty);
            $message = 'cart updated Successfully';
            $status = true;
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function deleteItem(Request $request)
    {
        $rowId = $request->rowId;
        $itemInfo = Cart::get($rowId);

        if ($itemInfo == null) {
            $errorMessage = 'Item Not Found in cart';
            session()->flash('error', $errorMessage);

            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ]);

        }

        Cart::remove($request->rowId);
        $message = 'Item removed Successfully';
        session()->flash('error', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function checkout(Request $request)
    {
        //if cart is empty
        if (Cart::count() == 0) {
            return redirect()->route('cart.cart');
        }

        //if user not login
        if (Auth::check() == false) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('account.login');
        }
        $customerAddress = CustomerAddress::where('user_id', Auth::user()->id)->first();
        session()->forget('url.intended');

        $countries = Country::orderBy('name', 'ASC')->get();

        $data['countries'] = $countries;
        $data['customerAddress'] = $customerAddress;

        return view('Front.checkout', $data);
    }

    public function checkoutProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
            'order_notes' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.checkout')
                ->with('error', 'Something Went Wrong')
                ->withInput($request->all())
                ->withErrors($validator);
        }

        $user = Auth::user();

        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'notes' => $request->order_notes ?? '',
            ]
        );

        if ($request->payment_method == 'cod') {
            $shipping = 0;
            $discount = 0;
            $subtotal = Cart::subtotal(2, '.', '');
            $grandTotal = $subtotal + $shipping;

            $order = new Orders();
            $order->subtotal = $subtotal;
            $order->shipping = $shipping;
            $order->discount = $discount;
            $order->grand_total = $grandTotal;
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->country_id = $request->country;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->zip = $request->zip;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->notes = $request->order_notes ?? ''; // Ensure 'notes' is never null
            $order->save();

            foreach (Cart::content() as $item) {
                $orderItem = new OrderItems();
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price * $item->qty;
                $orderItem->save();
            }


            Cart::destroy();
            return redirect()->route(
                'account.thankYou',
                [
                    'orderId' => $order->id,
                ]
            )->with('success', 'Order Placed Successfully');
        }

    }



    public function thankYou($orderId)
    {
        return view('front.thankyou', compact('orderId'));
    }


}
