<?php

namespace App\DTOs\Product;

use App\Enums\Status;
use App\Traits\DTOBasics;

class Create
{
    use DTOBasics;
    public function __construct(
        public string $title,
        public string $small_desc,
        public string $desc,
        public string|null $atributes,
        public int $quentity,
        public int $alert_quentity,
        public Status $status = Status::PUBLIC,
        public int|null $category_id,
    ){}
    /**
     * Create Product DTO From Request Validated Array
     * @param array $data
     * @return Create
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            title: $data['title'],
            small_desc: $data['small_desc'],
            desc: $data['desc'],
            atributes: $data['atributes'],
            quentity: $data['quentity'],
            alert_quentity: $data['alert_quentity'],
            status: Status::from($data['status'] ?? 1),
            category_id: isset($data['category_id'])? (int)$data['category_id'] : 1
        );
    }
}
