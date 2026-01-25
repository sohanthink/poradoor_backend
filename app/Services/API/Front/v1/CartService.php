<?php

namespace App\Services\API\Front\V1;

use App\Models\CartItem;
use App\DTOs\Cart\CartDTO;
use App\Repositories\API\Admin\v1\CartRepository;
;

class CartService
{
    protected $repository;
    public function __construct()
    {
        $this->repository = new CartRepository();
    }
    public function get_cart_items(): CartItem|null{
        return $this->repository->get_items();
    }
    public function add_to_cart($data): CartItem{
        $dto = CartDTO::fromRequest(data: $data);
        return $this->repository->create_cart_item(dto: $dto);
    }
    public function remove_from_cart(CartItem $cartItem): bool{
        return $this->repository->delete_cart_item(cartItem: $cartItem);
    }
    public function change_column(CartItem $cartItem, array $data): CartItem{
        return $this->repository->change_column(cartItem: $cartItem, data: $data);
    }
}
