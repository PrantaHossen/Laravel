<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest('id');
        if (!empty($request->get('keyword'))) {
            $products = $products->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $products = $products->paginate(5);
        //$data['products'] = $products;
        return view('Admin.products.index', compact('products'));
    }

    public function create()
    {
        $data = [];
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('Admin.products.create', $data);
    }

    // In YourController.php
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get(['id', 'name']);
        return response()->json($subcategories);
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        // If track_qty is Yes, qty must be required
        if ($request->track_qty === 'Yes') {
            $rules['qty'] = 'required|numeric|min:0';
        }

        if ($request->hasFile('image')) {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('product.create')
                ->withInput()
                ->withErrors($validator);
        }

        $slug = $request->slug;
        $existingProduct = Product::where('slug', $slug)->first();
        if ($existingProduct) {
            return redirect()->route('product.create')
                ->withInput()
                ->withErrors(['slug' => 'Product slug already exists.']);
        }

        // Create the product and let Laravel handle the ID assignment
        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->short_description = $request->shortDescription;
        $product->shipping_returns = $request->shipping_returns;
        $product->related_products = (!empty($request->related_products)) ? implode(',',$request->related_products) : '';
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->track_qty = $request->track_qty;
        $product->qty = $request->qty;
        $product->status = $request->status;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->brand_id = $request->brand;
        $product->is_featured = $request->is_featured;
        $product->save(); // ID is automatically generated and assigned

        // Image storing
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $product->id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('product.index')->with('success', 'Product Added Successfully');
    }






    public function show(Request $request)
    {
        //
    }

    public function edit($id, Request $request)
    {
        $data = [];
        $product = Product::find($id);
        $subCategories = SubCategory::where('category_id', $product->category_id)->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();

        //fetch related product
        $relatedProducts=[];
        if($product->related_products !='')
        {
            $productArray= explode(',',$product->related_products);
            $relatedProducts= Product::whereIn('id',$productArray)->get();
        }


        $data['product'] = $product;
        $data['subCategories'] = $subCategories;
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['relatedProducts'] = $relatedProducts;

        return view('admin.products.edit', $data);
    }


    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $rules = [
            'name' => 'required|min:3',
            'slug' => [
                'required',
                Rule::unique('products')->ignore($product->id),
            ],
            'price' => 'required|numeric',
            'sku' => [
                'required',
                Rule::unique('products')->ignore($product->id),
            ],
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:1,0',
        ];

        if ($request->track_qty === 'Yes') {
            $rules['qty'] = 'required|numeric|min:0';
        }

        if ($request->hasFile('image')) {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('product.edit', $product->id)
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'Products Not Updated');
        }
        if ($validator->passes()) {
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->short_description = $request->shortDescription;
            $product->shipping_returns = $request->shipping_returns;
            $product->related_products = (!empty($request->related_products)) ? implode(',',$request->related_products) : '';
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->save();
        }

        $product->fill($request->except('image'));
        $product->is_featured = $request->is_featured;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $product->id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product Updated Successfully');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Check if the image exists before trying to delete it
        $imagePath = public_path('uploads/products/' . $product->image);
        if (File::exists($imagePath)) {
            // Delete the image file
            File::delete($imagePath);
        }
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }


    public function getProducts(Request $request)
    {
        if($request->term !="")
        {
            $tempProduct=[];

            $products = Product::where('name','like','%'.$request->term.'%')->get();

            if($products !=null)
            {
                foreach($products as $product)
                {
                    $tempProduct[]=array('id'=>$product->id,'text'=>$product->name);
                }
            }
        }

        return response()->json([
            'tags'=>$tempProduct,
            'status'=>true
        ]);

    }

}
