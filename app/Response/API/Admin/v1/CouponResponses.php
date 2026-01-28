<?php

namespace App\Response\API\Admin\v1;

use App\Http\Resources\API\Admin\v1\CouponProductResource;
use App\Http\Resources\API\Admin\v1\CouponResource;
use App\Models\Coupon;
use App\Traits\APIResponse;

class CouponResponses
{
    use APIResponse;
    public function coupon_create_success_response($coupon)
    {
        return $this->success("Coupon Successfully Created", CouponResource::make($coupon),201);
    }
    public function coupon_create_error_response()
    {
        return $this->error("Error! Coupon Not Created. Something Went Wrong.");
    }
    public function all_coupon_response($coupons)
    {
        return $this->success("Coupon Fetch Successfully.", CouponResource::collection($coupons),201);
    }
    public function show_coupon_response(Coupon $coupon)
    {
        $data = [
            "coupon" => CouponResource::make($coupon), 
            "include_coupon_product" => CouponProductResource::collection($coupon->include_product), 
            "exclude_coupon_product" => CouponProductResource::collection($coupon->exclude_product), 
        ];
        return $this->success("Coupon Fetch Successfully.", $data,201);
    }
    public function delete_coupon_response(){
        return $this->success('Coupon Successfully Deleted.');
    }
    public function delete_coupon_error_response(){
        return $this->error('Error! Something Went Wrong.');
    }
}
