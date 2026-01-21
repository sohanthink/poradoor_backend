<?php

namespace App\Http\Controllers\API\Front\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\Api\Front\UserService;
use App\Response\Api\Front\v1\UserResponses;
use App\Http\Requests\API\Front\User\v1\UpdateUserRequest;
use App\Http\Requests\API\Front\User\v1\UpdateAvatarRequest;
use App\Http\Requests\API\Front\User\v1\UpdatePasswordRequest;

class UserController extends Controller
{
    private $user_service;
    private $user_response;
    public function __construct(){
        $this->user_service = new UserService();
        $this->user_response = new UserResponses();
    }
    public function index(Request $request){
        return UserResource::make($request->user());
    }
    public function update(UpdateUserRequest $request){
        if($this->user_service->update_user_data($request->validated())){
            return $this->user_response->user_data_update_success_response();
        }
        return $this->user_response->user_data_update_error_response();
    }
    public function update_password(UpdatePasswordRequest $request){
        if($this->user_service->update_user_password($request->validated())){
            return $this->user_response->user_password_update_success_response();
        }
        return $this->user_response->user_password_update_error_response();
    }
    public function update_avatar(UpdateAvatarRequest $request){
        $image = $this->user_service->change_avatar(); 
        if($image){
            return $this->user_response->user_password_update_success_response();
        }
        return $this->user_response->user_avatar_update_error_response();
    }
}
