<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::latest();
        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $categories = $categories->paginate(5);
        //$data['categories']=$categories;
        return view('admin.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'status' => 'required',
        ];
        if ($request->image != "") {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('categories.create')->withInput()->withErrors($validator);
        }

        $slug = Str::slug($request->name);
        $existingCategory = Category::where('slug', $slug)->first();
        if ($existingCategory) {
            return redirect()->route('categories.create')->withInput()->withErrors(['name' => 'Category name already exists.']);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->showHome = $request->showHome;
        $category->slug = Str::slug($request->name);
        $category->save();

        if ($request->image != "") {
            // Here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; // unique image name
            // save image into product folder
            $image->move(public_path('uploads/categories'), $imageName);
            // save image data in database
            $category->image = $imageName;
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category Added Successfully');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('Admin.categories.edit', [
            'categories' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $rules = [
            'name' => 'required|min:3',
            'status' => 'required',
        ];
        if ($request->image != "") {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('categories.edit', $category->id)->withInput()->withErrors($validator);
        }

        $category->name = $request->name;
        $category->status = $request->status;
        $category->showHome = $request->showHome;
        $category->save();

        if ($request->image != "") {

            //delete old picture
            File::delete(public_path('uploads/categories/' . '$categories->image'));

            //Here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; //unique image name
            //save image into product folder
            $image->move(public_path('uploads/categories'), $imageName);
            //save image data in database
            $category->image = $imageName;
            $category->save();
        }
        return redirect()->route('categories.index')->with('success', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        // Check if the image exists before trying to delete it
        $imagePath = public_path('uploads/categories/' . $category->image);
        if (File::exists($imagePath)) {
            // Delete the image file
            File::delete($imagePath);
        }

        // Delete the category record
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }

    
}
