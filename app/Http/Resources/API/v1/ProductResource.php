<?php

namespace App\Http\Resources\API\v1;

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
            "atributes" => $this->atributes,
            "quentity" => $this->quentity,
            "alert_quentity" => $this->alert_quentity,
            "status" => $this->status,
            "category" => CategoryResource::make($this->resource->category),
            "created_at" => $this->created_at?->format('d/m/Y h:i:s A'),
        ];
    }
}
