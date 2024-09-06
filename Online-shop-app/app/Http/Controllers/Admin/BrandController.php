<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    public function index(Request $request)
    {
        $brand = Brand::latest();
        if (!empty($request->get('keyword'))) {
            $brand = $brand->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $brand = $brand->paginate(5);
        //$data['categories']=$categories;
        return view('admin.brands.index', compact('brand'));
    }

    public function create()
    {
        return view('Admin.brands.create');
    }

    public function edit($id, Request $request)
    {
        $brands = Brand::find($id);
        if (empty($brands)) {
            return redirect()->route('brand.index')->with('error', 'Records Not Found');
        }
        return view('Admin.brands.edit', compact('brands'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|unique:brands,name',
            'status' => 'required',
            'slug' => 'required|unique:brands,slug',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('brand.create')->withInput()->withErrors($validator);
        }

        // Create new brand
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->slug = $request->slug;
        $brand->save();

        return redirect()->route('brand.index')->with('success', 'Brand Added Successfully');
    }



    public function update(Request $request, $id)
    {
        // Find the brand by its ID, or fail if not found
        $brand = Brand::findOrFail($id);

        // Define validation rules
        $rules = [
            'name' => 'required|min:3',
            'status' => 'required',
            'slug' => 'required|unique:brands,slug,' . $id,
        ];

        // Validate the request data against the rules
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, redirect back to the edit form with input and errors
        if ($validator->fails()) {
            return redirect()->route('brand.edit', $brand->id)
                ->withInput()
                ->withErrors($validator);
        }

        // Update the brand's attributes
        $brand->name = $request->input('name');
        $brand->status = $request->input('status');
        $brand->slug = $request->input('slug');  // Use the updated slug from the form

        // Save the updated brand back to the database
        $brand->save();

        // Redirect back to the brands index with a success message
        return redirect()->route('brand.index')->with('success', 'Brand Updated Successfully');
    }


    public function destroy($id)
    {
        // Find the brand by ID
        $brand = Brand::findOrFail($id);

        // Delete the brand
        $brand->delete();

        // Redirect back to the brand index with a success message
        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully.');
    }
}
