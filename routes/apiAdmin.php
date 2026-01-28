<?php

use App\Http\Controllers\API\Admin\v1\CategoryController;
use App\Http\Controllers\API\Admin\v1\CouponController;
use App\Http\Controllers\API\Admin\v1\ProductController;

Route::prefix('category')->controller(CategoryController::class)->middleware(['transaction'])->group(function (){
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::get('/{category}', 'show');
    Route::patch('/store/{category}', 'store');
    Route::delete('/delete/{category}', 'delete');
});
Route::prefix('product')->controller(ProductController::class)->middleware(['transaction'])->group(function (){
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::get('/{product}', 'show');
    Route::patch('/store/{product}', 'store');
    Route::delete('/delete/{product}', 'delete');
});
Route::prefix('coupon')->controller(CouponController::class)->middleware(['transaction'])->group(function (){
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::get('/{coupon}', 'show');
    Route::patch('/store/{coupon}', 'store');
    Route::delete('/delete/{coupon}', 'delete');
});