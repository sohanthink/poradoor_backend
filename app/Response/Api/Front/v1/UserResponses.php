<?php

namespace App\Response\Api\Front\v1;

use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;

class UserResponses
{
    use APIResponse;
    private $user;
    public function __construct()
    {
        $this->user = request()->user();
    }
    public function user_data_update_success_response(): JsonResponse{
        return $this->success(
            data: ["user" => UserResource::make(parameters: $this->user)]
        ,message: "Profile Update Successful");
    }
    public function user_data_update_error_response(): JsonResponse{
        return $this->error(
            message: ["user" => UserResource::make(parameters: $this->user)]
        ,code: "Profile Updated Failed");
    }
    public function user_password_update_success_response(): JsonResponse{
        return $this->success(
        data: [
            "user" => UserResource::make(parameters: $this->user),
            "token" => $this->user->createToken(name: "Api Token of {$this->user->name}")->plainTextToken
        ]
        ,message: "Password Update Successful");
    }
    public function user_password_update_error_response(): JsonResponse{
        return $this->error(message: "Password Updated Failed");
    }
    public function user_avatar_update_success_response($image): JsonResponse{
        return $this->success(
        data: [
            "url" => $image->getUrl(),
        ]
        ,message: "Avatar Update Successful");
    }
    public function user_avatar_update_error_response(): JsonResponse{
        return $this->error(message: "Avatar Updated Failed");
    }
}
