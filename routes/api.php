<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Front\v1\UserController;
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
});


