<?php

namespace App\Services\API\Front\V1;

use App\Enums\AddressType;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ShippingMethod;
use App\DTOs\Address\AddressDTO;
use App\DTOs\Order\OrderUpdateDTO;
use App\DTOs\OrderItem\OrderItemDTO;
use App\Services\API\Front\v1\CartService;
use App\Repositories\API\Front\v1\OrderRepository;
use App\Repositories\API\Front\v1\AddressRepository;
use App\Repositories\API\Front\v1\OrderItemRepository;
use App\Traits\APIResponse;

class OrderService
{
    use APIResponse;
    private $subtotal_amount = 0;
    private $total_amount = 0;
    private $shipping_charge = 0;
    private $order = null;
    private $shipping_address = null;
    private $cart = null;
    private $payment_status = PaymentStatus::UNPAID->value;
    private $order_status = OrderStatus::PENDING->value;
    private $payment_method = PaymentMethod::CASH_ON_DELIVARY->value;
    private $shipping_method = ShippingMethod::STANDARD->value;
    private $order_repository;
    private $order_item_repository;
    private $address_repository;
    private $cart_service;
    public function __construct()
    {
        $this->order_repository = new OrderRepository();
        $this->order_item_repository = new OrderItemRepository();
        $this->address_repository = new AddressRepository();
        $this->cart_service = new CartService();
    }
    public function get_shipping_charge(){
        return 0;
    }
    public function clear_cart($confirm = true){
        if($confirm){
            $this->cart->each->delete();
        }
    }
    public function get_order_array($data){
        return [
            "address_id" => $this->shipping_address->id,
            "payment_status" => $this->payment_status,
            "order_status" => $this->order_status,
            "payment_method" => $this->payment_method,
            "shipping_method" => $this->shipping_method,
            "subtotal_amount" => $this->subtotal_amount,
            "shipping_charge" => $this->shipping_charge,
            "total_amount" => $this->total_amount,
            "note" => $data['note'],
            "coupon_id" => $data['coupon_id'] ?? null,
            "user_id" => auth('sanctum')->id(),
            "guest_id" => $data['guest_id'] ?? null,
        ];
    }
    public function order_number(){
        $prefix = config('app.order_prefix', 'ORD');
        $date = now()->format('Ymdhis');
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
        $this->address_repository->save_address($dto);

    }
    public function get_shipping_address($data){
        $save = (bool)$data['save_shipping_address'];
        if($save){
            $this->save_user_or_guest_address($data);
        }
        $dto = AddressDTO::fromRequest(data: $data, type: AddressType::SHIPPING_ADDRESS->value);
        return $this->address_repository->save_address($dto);
    }
    public function create_order_item($cart_item, $order){
        $data = [];
        $data['order_id'] = $order->id;
        $data['product_id'] = $cart_item->product->id;
        $data['title'] = $cart_item->product->title;
        $data['quantity'] = $cart_item->quantity;
        $data['attributes'] = $cart_item->attributes;
        $data['price'] = $cart_item->product->price;
        $data['total'] = $cart_item->product->price * $cart_item->quantity;
        $dto = OrderItemDTO::create($data);
        return $this->order_item_repository->create($dto);
    }
    public function create_order($data){
        $this->cart = $this->cart_service->get_cart_items();
        if($this->cart->count() <= 0){
            $this->throw_error('No Item Found In The Cart', 400);
        }
        $this->order = $this->order_repository->inital_order( $this->get_order_number());
        foreach($this->cart as $cart_item){
            $order_item = $this->create_order_item($cart_item, $this->order);
            $this->subtotal_amount += $order_item->total;
        }
        $this->shipping_charge = $this->get_shipping_charge();
        $this->total_amount = $this->subtotal_amount + $this->shipping_charge;
        $order_data_array = $this->get_order_array($data);
        $order_dto = OrderUpdateDTO::create($order_data_array);
        $updated_order =  $this->order_repository->update_order($order_dto, $this->order);
        $updated_order->load(relations: 'order_items.product');
        $this->clear_cart(false);
        return $updated_order;
    }
    public function place_order($data){
        $this->shipping_address = $this->get_shipping_address($data);
        return $this->create_order($data);
    }
}
