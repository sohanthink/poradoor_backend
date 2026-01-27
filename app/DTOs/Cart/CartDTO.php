<?php

namespace App\DTOs\Cart;

use App\Traits\DTOBasics;

class CartDTO
{
    use DTOBasics;
    public function __construct(
       public string|null $guest_id = null,
       public int|null $user_id = null,
       public int $product_id,
       public int $quantity,
       public string|null $attributes = null,
    ){}
    public static function fromRequest(array $data): self
    {
        
        $obj = new self(
            guest_id: $data['guest_id'] ?? null,
            user_id: auth()->user()?->id ?? null,
            product_id: (int)$data['product_id'],
            quantity: (int)$data['quantity'],
            attributes: $data['attributes'] ?? null,
        );
        return $obj; 
    }
}
