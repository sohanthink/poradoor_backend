<?php

namespace App\Response\API\Front\v1;

use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\API\Front\v1\CartResource;

class CartResponses
{
    use APIResponse;
    public function cart_items_response($cart): JsonResponse{
        return $this->success(
            data: CartResource::collection($cart)
        ,message: "Cart Data Fetch Successsful.");
    } 
    public function add_to_cart_response($cart_item): JsonResponse{
        return $this->success(data: CartResource::make($cart_item), message: "Product Added To The Cart.", code: 201);
    }
    public function quentity_change_response($cart_item): JsonResponse{
        return $this->success(data: CartResource::make($cart_item), message: "Quentity Updated.", code: 201);
    }
    public function attribute_change_response($cart_item): JsonResponse{
        return $this->success(data: CartResource::make($cart_item), message: "Attribute Updated.", code: 201);
    }
    public function add_to_cart_error_response(): JsonResponse{
        return $this->error(message: 'Error! Product Not Added To The Cart.');
    }
    public function remove_cart_item_response(): JsonResponse{
        return $this->success(message: "Item Removed From Cart.");
    }
    public function error_response(): JsonResponse{
        return $this->error(message: 'Error! Something Went Wrong.');
    }
}
