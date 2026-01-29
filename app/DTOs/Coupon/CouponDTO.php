<?php

namespace App\DTOs\Coupon;

use App\Enums\CouponType;
use App\Enums\Status;
use App\Http\Requests\API\Admin\v1\CouponRequest;
use App\Traits\DTOBasics;

class CouponDTO
{
    use DTOBasics;
    public function __construct(
        public int|null $type,
        public int|null $status = Status::PUBLIC->value,
        public string|null $vaild_till,
        public string|null $coupon,
        public int|null $limit,
        public int|null $value,
        public int|null $usage = null,
    ){}

    public static function fromRequest(CouponRequest $request){
        $data = $request->validated();
        return new self(
            type: CouponType::from($data['type'] ?? null)->value,
            status: Status::from($data['status'] ?? null)->value,
            vaild_till: $data['vaild_till'] ?? null,
            coupon: $data['coupon'] ?? null,
            limit: $data['limit'] ?? null,
            value: $data['value'] ?? null,
            usage: $data['usage'] ?? null,
        );
    }
}
