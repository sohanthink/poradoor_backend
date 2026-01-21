<?php

namespace App\Services\Api\Auth\v1;

use App\DTOs\User\Create;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Api\Auth\v1\AuthRepository;

class AuthService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AuthRepository();
    }
    /**
     * Create a new user
     * @param array $data
     * @return User
     */
    public function create_user($data): User{
        $userData = new Create(
            name: $data['name'],
            email: $data['email'],
            password: Hash::make($data['password']),
            number: $data['number'],
            address: $data['address'] ?? ""
        );
        return $this->repository->store_user(data: $userData);
    }
    /**
     * Check credentials and get user
     * @param array $data
     * @return User|null
     */
    public function check_credentials($data): User|null{
        $credentials = [
            "email" => $data['email'],
            "password" => $data['password'],
        ];
        if(!Auth::attempt(credentials: $credentials)) return null;
        return $this->repository->get_user_by_email(email: $data['email']);
    }
    public function logout_current_user(){
        $request = request();
        return $request->user()->currentAccessToken()->delete();
    }
}
