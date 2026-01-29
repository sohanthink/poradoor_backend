<?php

namespace App\Response\API\Front\v1;

use App\Models\Order;
use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\API\Front\v1\OrderResource;

class OrderResponse{
    use APIResponse;
    public function order_success_response(Order $order): JsonResponse{
        return $this->success(message: "Order Placement Successful", data: OrderResource::make($order),code: 201);
    }
    public function order_error_response(): JsonResponse{
        return $this->error(message: "Error,Order Placement Failed");
    }
}