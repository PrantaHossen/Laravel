<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;

//Front Controller
Route::controller(FrontController::class)->group(function () {

    Route::get('/', 'index')->name('Front.index');
});


//Shop Controller
Route::controller(ShopController::class)->group(function () {

    Route::get('/shop/{categorySlug?}/{subCategorySlug?}', 'index')->name('shop.index');
    Route::get('/product/{slug}', 'product')->name('shop.product');

});

//Cart Controller
Route::controller(CartController::class)->group(function () {

    Route::get('/cart', 'cart')->name('cart.cart');
    Route::post('/addToCart', 'addToCart')->name('cart.addToCart');
    Route::post('/update-cart', 'updateCart')->name('cart.updateCart');
    Route::post('/delete-item', 'deleteItem')->name('cart.deleteItem.cart');
    route::get('/checkout', 'checkout')->name('account.checkout');
    route::post('/process-checkout', 'checkoutProcess')->name('account.checkoutProcess');
    route::get('/thankYou/{orderId}', 'thankYou')->name('account.thankYou');
});


Route::group(['prefix' => 'account'], function () {

    Route::group(['middleware' => 'guest'], function () {

        //Auth Controller
        Route::controller(AuthController::class)->group(function () {

            Route::get('/login', 'login')->name('account.login');
            Route::get('/register', 'register')->name('account.register');
            Route::post('/register-user', 'registerUser')->name('account.registerUser');
            Route::post('/login-user', 'loginProcess')->name('account.loginProcess');
            Route::get('/forgetPassword', 'forgetPassword')->name('account.forgetPassword');
            route::post('/check-email', 'checkEmail')->name('check.email');

        });
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::controller(AuthController::class)->group(function () {

            Route::get('/profile', 'profile')->name('account.profile');
            Route::get('/logout', 'logout')->name('account.logout');
        });
    });


    //Admin Side

    Route::group(['prefix' => 'admin'], function () {

        Route::group(['middleware' => 'admin.guest'], function () {
            Route::controller(AdminLoginController::class)->group(function () {
                Route::get('/login', 'index')->name('admin.login');
                Route::post('/authenticate', 'authenticate')->name('admin.authenticate');
            });
        });

        Route::group(['middleware' => 'admin.auth'], function () {

            // Admin Home Controller
            Route::controller(HomeController::class)->group(function () {
                Route::get('/dashboard', 'index')->name('admin.dashboard');
                Route::get('/logout', 'logout')->name('admin.logout');
            });

            // Admin Categories Controller
            Route::controller(CategoryController::class)->group(function () {
                Route::get('/categories', 'index')->name('categories.index');
                Route::get('/categories/create', 'create')->name('categories.create');
                Route::post('/categories', 'store')->name('categories.store');
                Route::get('/categories/{categories}/edit', 'edit')->name('categories.edit');
                Route::put('/categories/{categories}', 'update')->name('categories.update');
                Route::delete('/categories/{categories}', 'destroy')->name('categories.destroy');
            });

            // Admin Sub-Categories Controller
            Route::controller(SubCategoryController::class)->group(function () {
                Route::get('/sub-categories', 'index')->name('sub-categories.index');
                Route::get('/sub-categories/create', 'create')->name('sub-categories.create');
                Route::post('/sub-categories', 'store')->name('sub-categories.store');
                Route::get('/sub-categories/{subCategories}/edit', 'edit')->name('sub-categories.edit');
                Route::put('/sub-categories/{subCategories}', 'update')->name('sub-categories.update');
                Route::delete('/sub-categories/{subCategories}', 'destroy')->name('sub-categories.destroy');
            });

            // Admin Brand Controller
            Route::controller(BrandController::class)->group(function () {
                Route::get('/brand', 'index')->name('brand.index');
                Route::get('/brand/create', 'create')->name('brand.create');
                Route::post('/brand', 'store')->name('brand.store');
                Route::get('/brand/{brand}/edit', 'edit')->name('brand.edit'); // This should match the edit method
                Route::put('/brand/{brand}', 'update')->name('brand.update');
                Route::delete('/brand/{brand}', 'destroy')->name('brand.destroy');
            });


            //product controller

            Route::controller(ProductController::class)->group(function () {
                Route::get('/product', 'index')->name('product.index');
                Route::get('/product/create', 'create')->name('product.create');
                Route::post('/product', 'store')->name('product.store');
                Route::get('/product/{product}/edit', 'edit')->name('product.edit');
                Route::put('/product/{product}', 'update')->name('product.update');
                Route::delete('/product/{product}', 'destroy')->name('product.destroy');
                Route::get('/get-products', 'getProducts')->name('product.getProducts');
                Route::get('/get-subcategories/{categoryId}', 'getSubcategories')->name('product.getSubcategories');

            });

            // Admin Shipping Controller
            Route::controller(ShippingController::class)->group(function () {
                Route::get('/shipping', 'index')->name('shipping.index');
                Route::get('/shipping/create', 'create')->name('shipping.create');
                Route::post('/shipping', 'store')->name('shipping.store');
                Route::get('/shipping/{shipping}/edit', 'edit')->name('shipping.edit'); // This should match the edit method
                Route::put('/shipping/{shipping}', 'update')->name('shipping.update');
                Route::delete('/shipping/{shipping}', 'destroy')->name('shipping.destroy');
            });

        });
    });
});

