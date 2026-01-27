<?php

namespace App\Services\API\Front\V1;


use App\Helpers\ImageHelper;
use App\DTOs\User\UserUpdateDTO;
use Illuminate\Support\Facades\Hash;
use App\Repositories\API\Front\v1\UserRepository;
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
        $userUpdateData = new UserUpdateDTO(
            name: $data['name'],
            email: $data['email'] ?? null,
            number: $data['number'] ?? null,
            address: $data['address'] ?? null,
        );
        return $this->repository->update_user_model( dto: $userUpdateData, user: $this->user);
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