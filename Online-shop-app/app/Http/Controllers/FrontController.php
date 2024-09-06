<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $products= Product::where('is_featured','Yes')
        ->where('status',1)
        ->orderBy('id','DESC')
        ->take(5)
        ->get();
        $data['featureProducts']=$products;

        $latestProduct=Product::orderBy('id','DESC')->where('status',1)->take(5)->get();
        $data['latestProduct']=$products;
        return view('Front.Home',$data);
    }
}
