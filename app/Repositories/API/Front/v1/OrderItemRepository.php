<?php

namespace App\Repositories\API\Front\v1;

use App\DTOs\OrderItem\OrderItemDTO;
use App\Models\OrderItem;

class OrderItemRepository{
    public function create(OrderItemDTO $dto){
        return OrderItem::create(attributes: $dto->to_array());
    }
}