<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Shipping;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function index()
    {
        return view('admin.shipping.index');
    }

    public function create()
    {
        $countries = Country::get();

       // $shipping=shipping_charges::get();
        $data['countries'] = $countries;
        //$data['shipping'] = $shipping;
        return view('admin.shipping.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'amount' => 'required',
        ]);
        if($validator->passes())
        {
            $shipping = new Shipping();
            $shipping->country_id = $request->country_id;
            $shipping->amount = $request->amount;
            $shipping->save();
        }
        else{
            return redirect()->route('shipping.create')
            ->withErrors($request)
            ->withInput()
            ->with('error', 'Some Thing went wrong');
        }



        return redirect()->route('shipping.create')->with('success', 'Shipping added successfully');
    }
}
