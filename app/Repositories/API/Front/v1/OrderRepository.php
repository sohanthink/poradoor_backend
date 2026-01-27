<?php

namespace App\Repositories\API\Front\V1;

use App\DTOs\Order\OrderUpdateDTO;
use App\Models\Order;

class OrderRepository{
    public function inital_order($order_number){
        $order = new Order();
        $order->order_number = $order_number;
        $order->save();
        return $order;
    }
    public function check_exist_by_order_number($order_number){
        return Order::where('order_number',$order_number)->exists();
    }
    public function update_order(OrderUpdateDTO $dto, Order $order){
        $order->update($dto->to_array());
        return $order;
    }
}