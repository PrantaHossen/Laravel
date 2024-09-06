<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{

    public function index(Request $request)
    {
        $subCategories = SubCategory::select('sub_categories.*', 'categories.name as categoryName')
            ->latest('sub_categories.id')
            ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');
        /* // Start with a query to get all subcategories ordered by name
        $subCategories = SubCategory::orderBy('name');
 */
        // If a keyword is provided, filter the subcategories
        if (!empty($request->get('keyword'))) {
            $subCategories->where('sub_categories.name', 'like', '%' . $request->get('keyword') . '%');
            $subCategories->orWhere('categories.name', 'like', '%' . $request->get('keyword') . '%');
        }

        // Paginate the results with 5 items per page
        $subCategories = $subCategories->paginate(5);
        return view('Admin.sub_categories.list', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::orderBy('Name')->get();
        $data['categories'] = $categories;
        return view('Admin.sub_categories.create', $data);
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('sub-categories.create')->withInput()->withErrors($validator);
        }

        $slug = Str::slug($request->name);
        $existingCategory = SubCategory::where('slug', $slug)->first();

        if ($existingCategory) {
            return redirect()->route('sub-categories.create')->withInput()->withErrors(['name' => 'Category name already exists.']);
        }

        // Fetch the last ID and increment it
        $lastCategory = SubCategory::orderBy('id', 'desc')->first();
        $nextId = $lastCategory ? $lastCategory->id + 1 : 1;

        // Create new subcategory with the next ID
        $category = new SubCategory();
        $category->id = $nextId;  // Manually setting the ID
        $category->name = $request->name;
        $category->status = $request->status;
        $category->showHome = $request->showHome;
        $category->category_id = $request->category;
        $category->slug = $slug;
        $category->save();

        return redirect()->route('sub-categories.index')->with('success', 'Sub-category Added Successfully');
    }


    public function edit($id, Request $request)
    {
        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            return redirect()->route('sub-categories.index')->with('error', 'Records Not Found');
        }
        $categories = Category::orderBy('name')->get();

        // Use the correct keys
        return view('Admin.sub_categories.edit', [
            'categories' => $categories,
            'subCategory' => $subCategory
        ]);
    }


    public function update($id, Request $request)
    {
        $category = SubCategory::findOrFail($id);

        $rules = [
            'name' => 'required|min:3',
            'status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('sub-categories.edit', $category->id)->withInput()->withErrors($validator);
        }

        $slug = Str::slug($request->name);

        // Check if a subcategory with the same slug exists but exclude the current subcategory's ID
        $existingCategory = SubCategory::where('slug', $slug)->where('id', '!=', $category->id)->first();

        if ($existingCategory) {
            return redirect()->route('sub-categories.edit', $category->id)->withInput()->withErrors(['name' => 'Category name already exists.']);
        }

        // If no conflict, update the subcategory
        $category->name = $request->name;
        $category->status = $request->status;
        $category->showHome = $request->showHome;
        $category->category_id = $request->category;
        $category->slug = $slug;
        $category->save();

        return redirect()->route('sub-categories.index')->with('success', 'Sub-category updated successfully');
    }


    public function destroy($id)
    {
        $category = SubCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('sub-categories.index')->with('success', ' Sub-category deleted Successfully');
    }
}
