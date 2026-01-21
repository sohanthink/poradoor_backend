<?php

namespace App\Repositories\Api\Front\v1;

use App\DTOs\User\Update;
use App\Models\User;
use PhpParser\Node\Expr\Cast\Bool_;

class UserRepository{
    /**
     * Update User Data Of The Passed User Instance
     * @param Update $data
     * @param User $user
     * @return bool
     */
    public function update_user_model(Update $data, User $user): bool{
        return $user->update($data->toArray());
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