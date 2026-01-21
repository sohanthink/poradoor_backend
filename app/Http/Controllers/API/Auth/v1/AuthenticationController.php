<?php

namespace App\Http\Controllers\API\Auth\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\CRUDOparation;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Api\Auth\v1\AuthService;
use App\Http\Requests\API\Auth\v1\LoginRequest;
use App\Http\Requests\API\Auth\v1\RegistrationRequest;

class AuthenticationController extends Controller
{
    use CRUDOparation;
    private $auth_service;
    public function __construct(){
        $this->auth_service = new AuthService();
    }
    /**
     * Return success json response with user data and token
     * @param User $user
     * @param int $code
     * @return JsonResponse
     */
    private function success_user_response(User $user, string $message ,int $code): JsonResponse{
        return $this->apiSuccess(data: [
            "user" => $user,
            "token" => $user->createToken(name: "Api Token of $user->name")->plainTextToken
        ], message: $message,code: $code);
    }
    public function register(RegistrationRequest $request): JsonResponse
    {
        $user = $this->auth_service->create_user(data: $request->validated());
        return $this->success_user_response(user: $user, message: "User Created Successfully",code: 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->auth_service->check_credentials(data: $data);
        if(!$user){
            return $this->apiError(message: 'Invalid Credentials', code: 401);
        }
        return $this->success_user_response(user: $user,message: 'Login Successful', code: 200);
    }

    public function logout()
    {
        $logged_out = $this->auth_service->logout_current_user();
        if($logged_out){
            return $this->apiSuccess([],"Logout Successful");
        }
        return $this->apiError("Logout Failed");
    }
}