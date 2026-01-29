<?php

namespace App\Http\Resources\API\Admin\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'coupon' => $this->coupon,
            'limit' => $this->limit,
            'usage' => $this->usage,
            'value' => $this->value,
            'vaild_till' => $this->vaild_till,
            'status' => $this->status,
            'created_at' => $this->created_at?->format('d/m/Y h:i:s A'),
        ];
    }
}
