<?php

namespace App\Repositories\API\Front\V1;

use App\DTOs\Address\AddressDTO;
use App\Models\Address;

class AddressRepository{
    private $user;
    public function __construct() {
        $this->user = auth('sanctum')->user();
    }
    public function get_address_by_guest_id($guest_id){
        return Address::where('guest_id',$guest_id)->first();
    }
    public function get_address($data){
        $address = $this->user->saved_address;
        if($address){
            return $address;
        }
        $guest_id = $data['guest_id'] ?? null;
        if($guest_id){
            return $this->get_address_by_guest_id($guest_id);
        }
        return null;
    }
    public function update_address(Address $address, AddressDTO $dto){
        $address->update($dto->toArray());
        return $address;
    }
    public function save_address(AddressDTO $dto){
        return Address::create($dto->toArray());
    }
}