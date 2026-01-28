<?php

namespace App\Http\Resources\API\Front\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Front\v1\OrderItemResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "order_number" => $this->order_number,
            "order_items" => OrderItemResource::collection($this->order_items),
            "guest_id" => $this->guest_id,
            "user_id" => $this->user_id,
            "address_id" => $this->address_id,
            "coupon_id" => $this->coupon_id,
            "payment_status" => $this->payment_status,
            "order_status" => $this->order_status,
            "payment_method" => $this->payment_method,
            "shipping_method" => $this->shipping_method,
            "total_amount" => $this->total_amount,
            "subtotal_amount" => $this->subtotal_amount,
            "discount_amount" => $this->discount_amount,
            "shipping_charge" => $this->shipping_charge,
            "note" => $this->note,
            "created_at" => $this->created_at?->format('d/m/Y h:i:s A'),
        ];
    }
}
