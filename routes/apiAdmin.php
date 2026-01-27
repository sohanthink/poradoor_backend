<?php

use App\Http\Controllers\API\Admin\v1\CategoryController;
use App\Http\Controllers\API\Admin\v1\ProductController;

Route::prefix('category')->controller(CategoryController::class)->middleware(['transaction'])->group(function (){
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::patch('/store/{category}', 'store');
    Route::delete('/delete/{category}', 'delete');
});
Route::prefix('product')->controller(ProductController::class)->middleware(['transaction'])->group(function (){
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::patch('/store/{product}', 'store');
    Route::delete('/delete/{product}', 'delete');
});