<?php

namespace App\Services\Api\Front;

use App\Models\User;
use App\DTOs\User\Update;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Api\Front\v1\UserRepository;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserService{
    private $repository;
    private $user;
    public function __construct(){
        $this->repository = new UserRepository();
        $this->user = auth()->user(); 
    }
    /**
     * Update user data
     * @param array $data
     * @return bool
     */
    public function update_user_data(array $data): bool{
        $userUpdateData = new Update(
            name: $data['name'],
            email: $data['email'],
            number: $data['number'],
            address: $data['address'],
        );
        return $this->repository->update_user_model(data: $userUpdateData, user: $this->user);
    }
    /**
     * User current user password
     * @param array $data
     * @return bool
     */
    public function update_user_password(array $data): bool|null{
        return $this->repository->update_user_password(data: ["password" => Hash::make($data['new_password'])], user: $this->user);
    }
    /**
     * User current user avatar
     * @return Media|null|bool
     */
    public function change_avatar(): Media|null|bool{
        return ImageHelper::uploadImage($this->user, request(),"avatar");
    }
}