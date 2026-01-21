<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Front\v1\UserController;
use App\Http\Controllers\API\Auth\v1\AuthenticationController;

Route::group(['prefix' => 'v1/'], function (){
    Route::get('/test',function(){
        return ['success' => true, 'message' => 'Request Read Success'];
    });
    // Auth API Route
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthenticationController::class, 'register']);
        Route::post('/login', [AuthenticationController::class, 'login']);
        Route::delete('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
    });
    Route::prefix('user')->middleware(['auth:sanctum','transaction'])->group(function (){
        Route::get('/', [UserController::class, 'index']);
        Route::patch('/update', [UserController::class, 'update']);
        Route::patch('/update-password', [UserController::class, 'update_password']);
        Route::patch('/update-avatar', [UserController::class, 'update_avatar']);
    });
});


