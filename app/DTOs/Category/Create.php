<?php

namespace App\DTOs\Category;

use App\Enums\Status;
use App\Traits\DTOBasics;

class Create
{
    use DTOBasics;
    public function __construct
    (
        public string $name,
        public Status $status = Status::PUBLIC,
        public int|null $parent_id = null,
    )
    {}
    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            status: Status::from($data['status'] ?? 1),
            parent_id: $data['category_id'] ?? null
        );
    }
    
}
