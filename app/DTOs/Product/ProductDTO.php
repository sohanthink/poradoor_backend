<?php

namespace App\DTOs\Product;

use App\Enums\Status;
use App\Traits\DTOBasics;

class ProductDTO
{
    use DTOBasics;
    public function __construct(
        public string|null $title,
        public string|null $small_desc,
        public string|null $desc,
        public float|null $price,
        public float|null $regular_price,
        public string|null $atributes,
        public int|null $quantity,
        public int|null $alert_quantity,
        public Status $status = Status::PUBLIC,
        public int|null $category_id,
    ){}
    /**
     * Create Product DTO From Request Validated Array
     * @param array $data
     * @return ProductDTO
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            title: $data['title'] ?? null,
            small_desc: $data['small_desc'] ?? null,
            desc: $data['desc'] ?? null,
            price: $data['price'] ?? null,
            regular_price: $data['regular_price'] ?? null,
            atributes: $data['atributes'] ?? null,
            quantity: $data['quantity'] ?? null,
            alert_quantity: $data['alert_quantity'] ?? null,
            status: Status::from($data['status'] ?? 1),
            category_id: isset($data['category_id'])? (int)$data['category_id'] : 1
        );
    }
}
