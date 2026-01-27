<?php

namespace App\DTOs\Address;

use App\Enums\AddressType;
use App\Traits\DTOBasics;

class AddressDTO{
    use DTOBasics;
    public function __construct(
        public string $type,
        public string $name,
        public string $email,
        public string $phone,
        public string $city,
        public string $address,
        public int|null $user_id = null,
        public string|null $guest_id = null,
        public int|null $order_id = null,
        public string|null $delivary_area = null,
        public string|null $country = null,
        public string|null $zip_code = null,
        public string|null $additional_data = null,
    ){}
    public static function fromRequest($data, $type){
        return new self(
            type: $type,
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            city: $data['city'],
            address: $data['address'],
            user_id: ($type === AddressType::USER_SAVED->value) ? auth('sanctum')->id() : null,
            guest_id: ($type === AddressType::USER_SAVED->value && isset($data['guest_id'])) ? $data['guest_id'] : null,
            delivary_area: $data['delivary_area'] ?? null,
            country: $data['country'] ?? null,
            zip_code: $data['zip_code'] ?? null,
            additional_data: $data['additional_data'] ?? null,
        );
    }
}