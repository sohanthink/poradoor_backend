<?php

namespace App\Repositories\Api\Auth\v1;

use App\DTOs\User\Create;
use App\Models\User;

class AuthRepository
{
    public function __construct()
    {
        //
    }
    /**
     * A repository function to create user instance
     * @param Create $data
     * @return User
     */
    public function store_user(Create $data): User{
        return User::create(attributes: $data->toArray());
    }
    /**
     * A repository function to get user instance by email field
     * @param string $email
     * @return User|null
     */
    public function get_user_by_email(string $email): User|null{
        return User::where(column: 'email', operator: $email)->first();
    }
}
