<?php

namespace App\Http\Controllers\API\Front\v1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\API\Front\v1\CartService;
use App\Response\API\Front\v1\CartResponses;
use App\Http\Requests\API\Front\Cart\CartRequest;
use App\Http\Requests\API\Front\Cart\CartRemoveRequest;
use App\Http\Requests\API\Front\Cart\CartQuentityRequest;
use App\Http\Requests\API\Front\Cart\CartAttributeRequest;

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
        $cart_item = $this->cart_service->add_to_cart(data: $request->validated());
        if($cart_item){    
            return $this->cart_response->add_to_cart_response(cart_item: $cart_item);
        }
        return $this->cart_response->add_to_cart_error_response();
    }
    public function remove_from_cart(CartRemoveRequest $request): JsonResponse{
        if($this->cart_service->remove_from_cart(data: $request->all())){    
            return $this->cart_response->remove_cart_item_response();
        }
        return $this->cart_response->add_to_cart_error_response();
    }
    public function change_attributes(CartAttributeRequest $request): JsonResponse{
        $data = $this->cart_service->change_attributes(data: $request->validated());
        if($data){    
            return $this->cart_response->attribute_change_response(cart_item: $data);
        }
        return $this->cart_response->error_response();
    }
    public function change_quentity(CartQuentityRequest $request): JsonResponse{
        $data = $this->cart_service->change_quentity(data: $request->validated());
        if($data){    
            return $this->cart_response->quentity_change_response(cart_item: $data);
        }
        return $this->cart_response->error_response();
    }
}
