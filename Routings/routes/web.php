<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\TestignController;
use Illuminate\Support\Facades\Route;



Route::controller(PageController::class)->group(function(){

    Route::get("/",'ShowHome')->name('home');
    Route::get("/user/{id}",'AllUser')->name('users');
    Route::get("/blog",'blog')->name('blog');

});

Route::get("/test", TestignController::class);
