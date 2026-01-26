<?php

namespace App\Http\Resources\API\Front\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->resource->load('product:id,title');
        return [
            "id" => $this->id,
            "title" => $this->product->title,
            "image" => get_image_url($this->product,'hero_image'),
            "quantity" => (int)$this->quantity,
            "attributes" => $this->attributes,
        ];
    }
}
