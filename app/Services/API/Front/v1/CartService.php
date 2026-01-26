<?php

namespace App\Services\API\Front\V1;

use App\Models\CartItem;
use App\DTOs\Cart\CartDTO;
use App\Traits\APIResponse;
use Illuminate\Support\Collection;
use App\Repositories\API\Admin\v1\CartRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
;

class CartService
{
    use APIResponse;
    protected $repository;
    public function __construct()
    {
        $this->repository = new CartRepository();
    }
    public function get_cart_items(): Collection|null{
        $data = request()->only('guest_id');
        $this->no_user_no_guest($data);
        $cart_items = $this->repository->get_items_user();
        if($cart_items){
            return $cart_items;
        }
        $cart_items = $this->repository->get_items_guest($data['guest_id']);
        if($cart_items){
            return $cart_items;
        }
        return null;
    }
    public function no_user_no_guest($data): void{
        $user = auth('sanctum')->user();
        $guest = $data['guest_id'] ?? null;
        $this->throw_error_with_condition(condition: !$user && !$guest, message: "Authentication required: please log in or provide a guest ID", code: 401);
    }
    public function check_existing_cart_item($data): void{
        $user = auth('sanctum')->user();
        $guest_id = $data['guest_id'] ?? null;
        $product_id = $data['product_id'] ?? null;
        $exist = null;
        $exist = $user? $this->repository->get_item_by_product_id_user($user->id, $product_id): $exist;
        $exist = $guest_id? $this->repository->get_item_by_product_id_guest($guest_id, $product_id): $exist;
        $this->throw_error_with_condition($exist, message: "Product Already Exist In The Cart.", code: 400);
    }
    public function get_guest(){
        return request()->guest_id;
    }
    public function get_cart_item($data): CartItem|null{
        $guest_id = $data['guest_id'] ?? null;
        $user = auth(guard: 'sanctum')->user();
        if($user){
            $cart_item = $this->repository->get_item_by_user_id(user_id: $user->id, id: $data['cart_item_id']);
            if($cart_item){
                return $cart_item;
            }
        }
        if($guest_id){
            $cart_item = $this->repository->get_item_by_guest_id(guest_id: $guest_id, id: $data['cart_item_id']);
            if($cart_item){
                return $cart_item;
            }
        }
        return null;
    }
    public function add_to_cart($data): CartItem{
        $this->no_user_no_guest($data);
        $this->check_existing_cart_item($data);
        $dto = CartDTO::fromRequest(data: $data);
        return $this->repository->create_cart_item(dto: $dto);
    }
    public function remove_from_cart($data): bool{ 
        $cart_item = $this->get_cart_item($data);
        if(!$cart_item){
            $this->throw_error(message: 'Cart Item Not Found',code: 404);
        }
        return $this->repository->delete_cart_item(cartItem: $cart_item);
    }
    public function change_attributes(array $data): CartItem{
        $cart_item = $this->get_cart_item(data: $data);
        return $this->repository->change_column(cartItem: $cart_item, data: ['attributes' => $data['attributes']]);
    }
    public function change_quentity(array $data): CartItem{
        $cart_item = $this->get_cart_item(data: $data);
        return $this->repository->change_column(cartItem: $cart_item, data: ['quantity' => $data['quantity']]);
    }
}
