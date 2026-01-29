<?php

namespace App\Repositories\API\Front\v1;


use App\DTOs\User\UserUpdateDTO;
use App\Models\User;

class UserRepository{
    /**
     * Update User Data Of The Passed User Instance
     * @param UserUpdateDTO $dto
     * @param User $user
     * @return bool
     */
    public function update_user_model(UserUpdateDTO $dto, User $user): bool{
        return $user->update(array_filter($dto->to_array()));
    }
    /**
     * Update Password Of The Passed User Instance And Revoke All Existing Token
     * @param array $data
     * @param User $user
     * @return bool
     */
    public function update_user_password(array $data, User $user): bool{
        if($user->update($data)){
            $user->tokens()->delete();
            return true;
        }
        return false;
    }
}