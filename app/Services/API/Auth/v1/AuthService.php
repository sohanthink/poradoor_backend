<?php

namespace App\Services\API\Auth\v1;

use App\DTOs\User\Create;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\API\Auth\v1\AuthRepository;
use Str;

class AuthService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AuthRepository();
    }
    /**
     * Create a new user
     * @param string $name
     * @return string
     */
    public function getRandomUserName(string $name):string{
        return Str::snake($name).'_'. Str::random(3);
    }
    /**
     * Create a new user
     * @param array $data
     * @return User
     */
    public function create_user($data): User{
        $username = $data['username'] ?? $this->getRandomUserName($data['name']);
        $userData = new Create(
            name: $data['name'],
            email: $data['email'],
            username: $username,
            password: Hash::make($data['password']),
            number: $data['number'],
            address: $data['address'] ?? ""
        );
        return $this->repository->store_user( dto: $userData);
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
