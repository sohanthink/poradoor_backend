<?php

namespace App\Http\Controllers\API\Front\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\API\Front\v1\OrderService;
use App\Response\API\Front\v1\OrderResponse;
use App\Http\Requests\API\Admin\v1\OrderRequest;

class OrderController extends Controller
{
    private $order_service;
    private $order_response;
    public function __construct(){
        $this->order_service = new OrderService();
        $this->order_response = new OrderResponse();
    }
    public function place_order(OrderRequest $request){
        $order = $this->order_service->place_order($request->validated());
        if($order){
            $this->order_response->order_success_response($order);
        }
        return $this->order_response->order_error_response();
    }
}
