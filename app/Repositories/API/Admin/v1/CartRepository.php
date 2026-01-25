<?php

namespace App\Repositories\API\Admin\v1;

use App\DTOs\Cart\CartDTO;
use App\Models\CartItem;

class CartRepository
{
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }
    public function get_items(): CartItem|null{
        return $this->user?->cart_items;
    }
    /**
     * Create A New Cart Item Instance
     * @param CartDTO $data
     * @return CartItem
     */
    public function create_cart_item(CartDTO $dto): CartItem{
        return CartItem::create(attributes: $dto->toArray());
    }
    /**
     * Delete A Cart Item Instance
     * @param CartItem $cartItem
     * @return bool|null
     */
    public function delete_cart_item(CartItem $cartItem): bool{
        return $cartItem->delete();
    }
    public function change_column(CartItem $cartItem, $data): CartItem{
        $cartItem->update(attributes: $data);
        return $cartItem;
    }
}
