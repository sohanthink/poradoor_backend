<?php

namespace App\DTOs\Product;

use App\Enums\Status;
use App\Traits\DTOBasics;

class ProductDTO
{
    use DTOBasics;
    public function __construct(
        public string $title,
        public string $small_desc,
        public string $desc,
        public float $price,
        public float|null $regular_price,
        public string|null $atributes,
        public int $quantity,
        public int $alert_quantity,
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
            title: $data['title'],
            small_desc: $data['small_desc'],
            desc: $data['desc'],
            price: $data['price'],
            regular_price: $data['regular_price'] ?? null,
            atributes: $data['atributes'],
            quantity: $data['quantity'],
            alert_quantity: $data['alert_quantity'],
            status: Status::from($data['status'] ?? 1),
            category_id: isset($data['category_id'])? (int)$data['category_id'] : 1
        );
    }
}
