<?php

namespace App\Models;

use App\Enums\CouponProductType;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = ["id","created_at","updated_at"];
    public function include_product(){
        return $this->hasMany(CouponProduct::class)->where('type',CouponProductType::INCLUDE->value);
    }
    public function exclude_product(){
        return $this->hasMany(CouponProduct::class)->where('type',CouponProductType::EXCLUDE->value);
    }
}
