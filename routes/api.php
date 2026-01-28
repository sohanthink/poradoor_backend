<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Front\v1\CartController;
use App\Http\Controllers\API\Front\v1\ShopController;
use App\Http\Controllers\API\Front\v1\UserController;
use App\Http\Controllers\API\Front\v1\OrderController;
use App\Http\Controllers\API\Front\v1\FrontendController;
use App\Http\Controllers\API\Auth\v1\AuthenticationController;

Route::group(['prefix' => 'v1/'], function (){
    Route::get('/test',function(){
        return ['success' => true, 'message' => 'Request Read Success'];
    });
    // Auth API Route
    Route::prefix('auth')->controller(AuthenticationController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::delete('/logout', 'logout')->middleware('auth:sanctum');
    });
    Route::prefix('user')->middleware(['auth:sanctum','transaction'])->controller(UserController::class)->group(function (){
        Route::get('/',  'index');
        Route::patch('/update', 'update');
        Route::patch('/update-password',  'update_password');
        Route::patch('/update-avatar', 'update_avatar');
        });
    Route::controller(FrontendController::class)->group(function (){
        Route::post('/track-order',  'track_order');
        Route::post('/save-contact',  'save_contact');
    });
    Route::prefix('/cart')->controller(CartController::class)->group(function (){
        Route::get('/',  'index');
        Route::post('/add-to-cart',  'add_to_cart')->middleware('auth:sanctum');
        Route::delete('/remove-from-cart',  'remove_from_cart');
        Route::patch('/change-attributes',  'change_attributes');
        Route::patch('/change-quantity',  'change_quentity');
    });
    Route::controller(ShopController::class)->prefix('shop/')->group(function (){
        Route::get('/products',   'products');
        Route::get('/products/filter',  'product_filter');
        Route::get('/categories',  'categories');
        Route::get('/product/{product:slug}',  'product_details');
        Route::get('/category/{category:slug}',  'category_details');
    });
    Route::post('place-order',[OrderController::class, "place_order"])->middleware('transaction');
});


