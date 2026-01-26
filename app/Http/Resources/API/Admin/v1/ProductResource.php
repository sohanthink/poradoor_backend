<?php

namespace App\Http\Resources\API\Admin\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->title,
            "slug" => $this->slug,
            "hero_image" => get_image_url($this->resource, 'hero_image'),
            "secondary_image" => get_image_url($this->resource, 'secondary_image'),
            "images" => get_multiple_image_url($this->resource, 'images'),
            "small_desc" => $this->small_desc,
            "desc" => $this->desc,
            "price" => get_price($this->resource),
            "regular_price" => $this->regular_price,
            "atributes" => $this->atributes,
            "quantity" => $this->quantity,
            "alert_quantity" => $this->alert_quantity,
            "status" => $this->status,
            "category" => CategoryResource::make($this->resource->category),
            "created_at" => $this->created_at?->format('d/m/Y h:i:s A'),
        ];
    }
}
