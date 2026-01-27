<?php

namespace App\DTOs\Order;

use App\Traits\DTOBasics;

class OrderUpdateDTO
{
    use DTOBasics;
    public function __construct(
        public int $address_id, 
        public int $payment_status,
        public int $order_status,
        public int $payment_method,
        public int $shipping_method,
        public float $subtotal_amount,
        public float $shipping_charge,
        public float $total_amount,
        public string|null $note = null,
        public int|null $coupon_id = null,
        public int|null $user_id = null,
        public string|null $guest_id = null,
    ){}

    public static function create(array $data){
        return new self(
            address_id: $data['address_id'],
            payment_status: $data['payment_status'],
            order_status: $data['order_status'],
            payment_method: $data['payment_method'],
            shipping_method: $data['shipping_method'],
            subtotal_amount: $data['subtotal_amount'],
            shipping_charge: $data['shipping_charge'],
            total_amount: $data['total_amount'],
            note: $data['note'],
            coupon_id: $data['coupon_id'],
            user_id: $data['user_id'],
            guest_id: $data['guest_id'],
        );
    }
}
