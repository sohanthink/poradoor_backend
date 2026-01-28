<?php

namespace App\Http\Controllers\API\Admin\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\v1\CouponRequest;
use App\Models\Coupon;
use App\Response\API\Admin\v1\CouponResponses;
use App\Services\API\Admin\v1\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private $coupon_service;
    private $coupon_response;
    public function __construct() {
        $this->coupon_service = new CouponService();
        $this->coupon_response = new CouponResponses();
    }
    public function index(){
        return $this->coupon_response->all_coupon_response($this->coupon_service->all_coupon());
    }
    public function store(CouponRequest $request, Coupon $coupon = null){
        $is_create = $coupon? false: true;
        $coupon = $this->coupon_service->save_coupon($request, $coupon, $is_create);
        if($coupon){
            return $this->coupon_response->coupon_create_success_response($coupon);
        }
        return $this->coupon_response->coupon_create_error_response();
    }
    public function show(Coupon $coupon){
        $coupon->load('include_product.product');
        $coupon->load('exclude_product.product');
        return $this->coupon_response->show_coupon_response($coupon);
    }
    public function delete(Coupon $coupon){
        if($this->coupon_service->delete_coupon($coupon)){
            return $this->coupon_response->delete_coupon_response();
        }
        return $this->coupon_response->delete_coupon_error_response();
    }
}
