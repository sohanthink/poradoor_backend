<?php

namespace App\Http\Resources\API\Admin\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "slug" => $this->slug,
            "image" => get_image_url($this->resource, 'image'),
            "status" => $this->status,
            "parent_category" => CategoryResource::make($this->resource->parent_id),
            "created_at" => $this->created_at?->format('d/m/Y h:i:s A'),
        ];
    }
}
