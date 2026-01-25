<?php

namespace App\DTOs\Cart;

use App\Traits\DTOBasics;

class CartDTO
{
    use DTOBasics;
    public function __construct(
       string|null $guest_id = null,
       int|null $user_id,
       int $product_id,
       int $quantity,
       string $attributes = null,
    ){}
     public static function fromRequest(array $data): self
    {
        return new self(
            guest_id: $data['guest_id'] ?? null,
            user_id: auth()->user() ?? null,
            product_id: $data['product_id'],
            quantity: $data['quantity'],
            attributes: $data['attributes'] ?? null,
        );
    }
}
