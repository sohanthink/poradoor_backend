<?php

namespace  App\Http\Resources\API\Front\v1\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductLiteWeightResource extends JsonResource{
    public function toArray(Request $request): array{
        return [
            'id' => $this->id,
            'image' => get_image_url($this->resource, 'hero_image'),
            'title' => $this->title,
            'price' => $this->price,
            'regular_price' => $this->regular_price,
        ];
    }
}