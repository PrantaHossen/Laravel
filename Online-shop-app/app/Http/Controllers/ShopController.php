<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request,$categorySlug=null,$subCategorySlug=null)
    {
        $categorySelected='';
        $subCategorySelected='';
        $brandsArray= [];

        $categories=Category::orderBy('name','ASC')->with('sub_category')->where('status',1)->get();
        $brands=Brand::orderBy('name','ASC')->where('status',1)->get();
        $products= Product::where('status',1);

        //Apply Filter

        if(!empty($categorySlug))
        {
            $category= Category::where('slug',$categorySlug)->first();
            $products=$products->where('category_id',$category->id);
            $categorySelected= $category->id;
        }

        if (!empty($subCategorySlug)) {
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();

            if ($subCategory) {
                $products = $products->where('sub_category_id', $subCategory->id);
                $subCategorySelected = $subCategory->id;
            } else {

            }
        }

        if(!empty($request->get('brand')))
        {
            $brandsArray= explode(',',$request->get('brand'));
            $products=$products->whereIn('brand_id',$brandsArray);
        }

        if ($request->get('price_max') != '' && $request->get('price_min') != '') {

            if($request->get('price_max') ==10000 ){
                $products = $products->whereBetween('price', [
                    intval($request->get('price_min')),
                    1000000
                ]);
            }
            else{
                $products = $products->whereBetween('price', [
                    intval($request->get('price_min')),
                    intval($request->get('price_max'))
                ]);
            }
        }

        if($request->get('sort')!='')
        {
            if($request->get('sort')=='latest')
            {
                $products= $products->orderBy('id','DESC');
            }
            elseif($request->get('sort')=='price_asc')
            {
                $products= $products->orderBy('price','ASC');
            }
            else{
                $products= $products->orderBy('price','DESC');
            }
        }
        else{
            $products= $products->orderBy('id','DESC');
        }
        $products= $products->paginate(6);

        //$products=Product::orderBy('id','DESC')->where('status',1)->get();
        $data['categories']=$categories;
        $data['brands']=$brands;
        $data['products']=$products;
        $data['categorySelected']=$categorySelected;
        $data['subCategorySelected']=$subCategorySelected;
        $data['brandsArray']=$brandsArray;
        $data['priceMax']=(intval(intval($request->get('price_max'))==0)?10000 : intval($request->get('price_max')));
        $data['priceMin']=intval($request->get('price_min'));
        $data['sort']=$request->get('sort');
        return view('Front.shop',$data);
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if ($product == null) {
            abort(404);
        }
        $data['product']= $product ;

        //fetch related product
        $relatedProducts=[];
        if($product->related_products !='')
        {
            $productArray= explode(',',$product->related_products);
            $relatedProducts= Product::whereIn('id',$productArray)->get();
        }
        $data['product']= $product ;
        $data['relatedProducts']= $relatedProducts ;


        return view('Front.product',$data);
    }
}
