<?php

namespace App\Services\API\Front\V1;

use App\Models\Order;
use App\Enums\AddressType;
use App\DTOs\Address\AddressDTO;
use App\Services\API\Front\v1\CartService;
use App\Repositories\API\Front\v1\OrderRepository;
use App\Repositories\API\Front\v1\AddressRepository;

class OrderService
{
    private $order_repository;
    private $address_repository;
    private $cart_service;
    public function __construct()
    {
        $this->order_repository = new OrderRepository();
        $this->address_repository = new AddressRepository();
        $this->cart_service = new CartService();
    }
    public function order_number(){
        $prefix = config('app.order_prefix', 'ORD');
        $date = now()->format('Ymd');
        $random = strtoupper(str()->random(6));

        return "{$prefix}-{$date}-{$random}";
    }
    public function get_order_number(){
        do {
            $number = $this->order_number();
        } while ($this->order_repository->check_exist_by_order_number($number));

        return $number;
    }
    public function save_user_or_guest_address($data){
        $dto = AddressDTO::fromRequest(data: $data, type: AddressType::USER_SAVED->value);
        $address = $this->address_repository->get_address($data);
        if($address){
            $this->address_repository->update_address($address, $dto);
        }
        $this->address_repository->save_address($data);

    }
    public function get_shipping_address($data){
        $save = (bool)$data['save_shipping_address'];
        if($save){
            $this->save_user_or_guest_address($data);
        }
        $dto = AddressDTO::fromRequest(data: $data, type: AddressType::SHIPPING_ADDRESS->value);
        return $this->address_repository->save_address($dto);
    }
    public function crete_order_item($cart_item, $order){
        // star here tomorrow
    }
    public function create_order($data){
        $cart = $this->cart_service->get_cart_items();
        $order = $this->order_repository->inital_order( $this->get_order_number());
        $order_items = [];
        foreach($cart as $cart_item){
            $order_items[] = $this->crete_order_item($cart_item, $order);
        }
    }
    public function place_order($data){
        $shipping_address = $this->get_shipping_address($data);
        $order = $this->create_order($data);
    }
}
