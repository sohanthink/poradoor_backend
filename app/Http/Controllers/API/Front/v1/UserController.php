<?php

namespace App\Http\Controllers\API\Front\v1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\API\Front\v1\UserService;
use App\Http\Resources\API\v1\UserResource;
use App\Response\API\Front\v1\UserResponses;
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
    public function index(Request $request): UserResource{
        return UserResource::make($request->user());
    }
    public function update(UpdateUserRequest $request): JsonResponse{
        if($this->user_service->update_user_data($request->validated())){
            return $this->user_response->user_data_update_success_response();
        }
        return $this->user_response->user_data_update_error_response();
    }
    public function update_password(UpdatePasswordRequest $request): JsonResponse{
        if($this->user_service->update_user_password(data: $request->validated())){
            return $this->user_response->user_password_update_success_response();
        }
        return $this->user_response->user_password_update_error_response();
    }
    public function update_avatar(UpdateAvatarRequest $request): JsonResponse{
        $image = $this->user_service->change_avatar(); 
        if($image){
            return $this->user_response->user_avatar_update_success_response(image: $image);
        }
        return $this->user_response->user_avatar_update_error_response();
    }
}
