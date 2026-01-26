<?php

namespace App\Repositories\API\Admin\v1;

use App\Models\CartItem;
use App\DTOs\Cart\CartDTO;
use Illuminate\Support\Collection;

class CartRepository
{
    protected $user;

    public function __construct()
    {
        $this->user = auth("sanctum")->user();
    }
    public function get_items_user(): Collection|null{
        return $this->user?->cart_items;
    }
    public function get_items_guest($guest_id): Collection|null{
        return CartItem::where('guest_id',$guest_id)->get();
    }
    /**
     * Create A New Cart Item Instance
     * @param CartDTO $data
     * @return CartItem
     */
    public function create_cart_item(CartDTO $dto): CartItem{
        return CartItem::create(attributes: $dto->toArray());
    }
    public function get_item_by_guest_id(string $guest_id, int $id){
        return CartItem::where('guest_id',$guest_id)->where('id',$id)->first();
    }
    public function get_item_by_user_id(int $user_id, int $id){
        return CartItem::where('user_id',$user_id)->where('id',$id)->first();
    }
    public function get_item_by_product_id_user(int $user_id, int $product_id){
        return CartItem::where('user_id',$user_id)->where('product_id',$product_id)->first();
    }
    public function get_item_by_product_id_guest(string $guest_id, int $product_id){
        return CartItem::where('guest_id',$guest_id)->where('product_id',$product_id)->first();
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
