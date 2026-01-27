<?php

namespace App\DTOs\User;

use App\Traits\DTOBasics;

class UserUpdateDTO
{
    use DTOBasics;
    public function __construct(
            public string $name,
            public string|null $email = null,
            public string|null $number = null,
            public string|null $address = "",
    )
    {}
}
