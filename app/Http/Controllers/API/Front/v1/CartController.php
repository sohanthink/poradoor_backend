<?php

namespace App\Http\Controllers\API\Front\v1;

use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\API\Front\v1\CartService;
use App\Response\API\Front\v1\CartResponses;
use App\Http\Requests\API\Admin\v1\Cart\CartRequest;
use App\Http\Requests\API\Admin\v1\Cart\CartQuentityRequest;
use App\Http\Requests\API\Admin\v1\Cart\CartAttributeRequest;

class CartController extends Controller
{
    private $cart_service;
    private $cart_response;
    public function __construct(){
        $this->cart_service = new CartService();
        $this->cart_response = new CartResponses();
    }
    public function index(): JsonResponse{
        return $this->cart_response->cart_items_response(cart: $this->cart_service->get_cart_items());
    }
    public function add_to_cart(CartRequest $request): JsonResponse{
        $data = $this->cart_service->add_to_cart(data: $request->validated());
        if($data){    
            return $this->cart_response->add_to_cart_response(data: $data);
        }
        return $this->cart_response->add_to_cart_error_response();
    }
    public function remove_from_cart(CartItem $cartItem): JsonResponse{
        if($this->cart_service->remove_from_cart(cartItem: $cartItem)){    
            return $this->cart_response->remove_cart_item_response();
        }
        return $this->cart_response->add_to_cart_error_response();
    }
    public function change_attributes(CartItem $cartItem, CartAttributeRequest $request): JsonResponse{
        $data = $this->cart_service->change_column(cartItem: $cartItem,data: $request->validated());
        if($data){    
            return $this->cart_response->attribute_change_response(data: $data);
        }
        return $this->cart_response->error_response();
    }
    public function change_quentity(CartItem $cartItem, CartQuentityRequest $request): JsonResponse{
        $data = $this->cart_service->change_column(cartItem: $cartItem,data: $request->validated());
        if($data){    
            return $this->cart_response->quentity_change_response(data: $data);
        }
        return $this->cart_response->error_response();
    }
}
