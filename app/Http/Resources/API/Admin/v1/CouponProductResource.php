<?php

namespace App\Http\Resources\API\Admin\v1;

use App\Http\Resources\API\Front\v1\Product\ProductLiteWeightResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'product_id' => $this->product_id,
            'product' => ProductLiteWeightResource::make($this->resource->product),
            'coupon_id' => $this->coupon_id,
            'created_at' => $this->created_at?->format('d/m/Y h:i:s A'),
        ];
    }
}
