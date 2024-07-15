<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Products::orderBy('id')->get();
        return view('products.list',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'sku' => 'required',
            'price' => 'required|numeric'
        ];
        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        $product = new Products();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != "") {
            //Here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; //unique image name
            //save image into product folder
            $image->move(public_path('uploads/products'), $imageName);
            //save image data in database
            $product->image = $imageName;
            $product->save();
        }
        return redirect()->route('products.index')->with('success', 'Product Added Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product=Products::findOrFail($id);

        return view('products.edit',[
            'product'=> $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request)
    {
        $product=Products::findOrFail($id);
        $rules = [
            'name' => 'required|min:3',
            'sku' => 'required',
            'price' => 'required|numeric'
        ];
        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.edit',$product->id)->withInput()->withErrors($validator);
        }

        //here we will update product
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != "")
        {

            //delete old picture
            File::delete(public_path('uploads/products'.'$product->image'));

            //Here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; //unique image name
            //save image into product folder
            $image->move(public_path('uploads/products'), $imageName);
            //save image data in database
            $product->image = $imageName;
            $product->save();
            return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
        }
    }
    //delete the product
    public function destroy($id)
    {
        $product=Products::findOrFail($id);

        //delete image
        File::delete(public_path('uploads/products'.$product->image));
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted Successfully');

    }
    }

