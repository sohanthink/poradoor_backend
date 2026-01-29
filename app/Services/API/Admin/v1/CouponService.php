<?php

namespace App\Services\API\Admin\v1;

use App\DTOs\Coupon\CouponDTO;
use App\Enums\CouponProductType;
use App\Http\Requests\API\Admin\v1\CouponRequest;
use App\Models\Coupon;
use App\Repositories\API\Admin\v1\CouponRepository;

class CouponService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new CouponRepository();
    }
    public function save_coupon(CouponRequest $request, Coupon $coupon = null, bool $is_create = true)
    {
        $data = $request->validated();
        $dto = CouponDTO::fromRequest($request);
        $coupon = $this->repository->save($dto, $coupon);
        $types = [
            'product_include' => CouponProductType::INCLUDE,
            'product_exclude' => CouponProductType::EXCLUDE,
        ];

        if((!empty($data['product_exclude']) || !empty($data['product_include'])) && !$is_create){
            $this->repository->unlink_coupon_product($coupon, CouponProductType::INCLUDE);
            $this->repository->unlink_coupon_product($coupon, CouponProductType::EXCLUDE);
        }
        
        foreach ($types as $key => $type) {
            if (!empty($data[$key])) {
                $this->repository->create_coupon_product_link($coupon, $data[$key], $type);
                break;
            }
        }
        return $coupon;
    }
    public function all_coupon(){
        return $this->repository->coupons();
    }
    public function delete_coupon(Coupon $coupon){
        return $this->repository->delete($coupon);
    }
}
