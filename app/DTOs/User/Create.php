<?php

namespace App\DTOs\User;

use App\Traits\DTOBasics;

class Create
{
    use DTOBasics;
    public function __construct(
            public string $name,
            public string $username = "",
            public string $email,
            public string $password,
            public string $number,
            public string $address = "",
    )
    {}
}
