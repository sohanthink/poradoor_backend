<?php

namespace App\DTOs\OrderItem;

use App\Traits\DTOBasics;

class OrderItemDTO{
    use DTOBasics;
    function __construct(
        public int $order_id,
        public int $product_id,
        public string $title,
        public int $quantity,
        public string $attributes,
        public float $price,
        public float $total,
    ){}
    public static function create($data){
        return new self(
            order_id: $data['order_id'],
            product_id: $data['product_id'],
            title: $data['title'],
            quantity: $data['quantity'],
            attributes: $data['attributes'],
            price: $data['price'],
            total: $data['total'],
        );
    } 
}