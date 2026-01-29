<?php

namespace App\Http\Resources\API\Front\v1;

use App\Http\Resources\API\Front\v1\Product\ProductLiteWeightResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            "product" => ProductLiteWeightResource::make($this->product),
            "title" => $this->title,
            "quantity" => $this->quantity,
            "attributes" => $this->attributes,
            "price" => $this->price,
            "total" => $this->total,
        ];
    }
}
