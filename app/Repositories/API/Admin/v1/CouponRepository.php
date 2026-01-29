<?php

namespace App\Repositories\API\Admin\v1;

use App\DTOs\Coupon\CouponDTO;
use App\Enums\CouponProductType;
use App\Models\Coupon;
use App\Models\CouponProduct;

class CouponRepository
{
    public function get_coupon($coupon){
        return Coupon::with('include_product.product','exclude_product.product')->where('coupon', $coupon)->first();
    }
    public function save(CouponDTO $dto, Coupon $coupon = null)
    {
        if($coupon){
            $coupon->update(array_filter($dto->to_array()));
            return $coupon;
        }
        return Coupon::create(array_filter($dto->to_array()));
    }
    public function coupons(){
        return Coupon::paginate(config('model.paginate_limit'));
    }
    public function create_coupon_product(Coupon $coupon, int $product_id, CouponProductType $coupon_product_type)
    {
        return CouponProduct::create([
            "type" => $coupon_product_type->value,
            "coupon_id" => $coupon->id,
            "product_id" => $product_id,
        ]);
    }
    public function create_coupon_product_link(Coupon $coupon, array $product_ids, CouponProductType $coupon_product_type)
    {
        $coupon_products = [];
        foreach ($product_ids as $product_id){
            $coupon_products[] = $this->create_coupon_product($coupon, $product_id, $coupon_product_type);
        }
        return $coupon_products;
    }
    public function unlink_coupon_product(Coupon $coupon, CouponProductType $coupon_product_type){
        if($coupon_product_type == CouponProductType::INCLUDE){
            $coupon->include_product()->delete();
        }
        if($coupon_product_type == CouponProductType::EXCLUDE){
            $coupon->exclude_product()->delete();
        }
    }
    public function delete(Coupon $coupon){
        return $coupon->delete();
    }
    public function increase_useage(Coupon $coupon){
        $coupon->usage++;
        $coupon->save();
        return $coupon->usage;
    }
}
