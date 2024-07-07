<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function ShowHome(){
        return view('home');
    }

    public function users(){
        return view('user');
    }
    public function AllUser(string $id){

        return view('user',compact('id'));
        //return view('User',['id'=>$id]);
    }

    public function blog(){
        return view('blog');
    }
}
