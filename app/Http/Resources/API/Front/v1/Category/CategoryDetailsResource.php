<?php

namespace App\Http\Resources\API\Front\v1\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Admin\v1\CategoryResource;
use App\Http\Resources\API\Front\v1\Product\ProductLiteWeightResource;

class CategoryDetailsResource extends JsonResource{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "products" => ProductLiteWeightResource::collection($this->products),
            "slug" => $this->slug,
            "image" => isset($this->resource->image_url)? $this->resource->image_url: get_image_url($this->resource, 'image'),
            "status" => $this->status,
            "parent_category" => CategoryResource::make($this->resource->parent_id),
            "created_at" => $this->created_at?->format('d/m/Y h:i:s A'),
        ];
    }
}