<?php

namespace App\Response\API\Front\V1;

use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\API\v1\CartResource;

class CartResponses
{
    use APIResponse;
    public function cart_items_response($cart): JsonResponse{
        return $this->success(
            data: ["cart" => CartResource::make(parameters: $cart)]
        ,message: "Profile Update Successful.");
    } 
    public function add_to_cart_response($data): JsonResponse{
        return $this->success(data: $data, message: "Product Added To The Cart.", code: 201);
    }
    public function quentity_change_response($data): JsonResponse{
        return $this->success(data: $data, message: "Quentity Updated.", code: 201);
    }
    public function attribute_change_response($data): JsonResponse{
        return $this->success(data: $data, message: "Attribute Updated.", code: 201);
    }
    public function add_to_cart_error_response(): JsonResponse{
        return $this->error(message: 'Error! Product Not Added To The Cart.');
    }
    public function remove_cart_item_response(): JsonResponse{
        return $this->success(message: "Product Added To The Cart.");
    }
    public function error_response(): JsonResponse{
        return $this->error(message: 'Error! Something Went Wrong.');
    }
}
