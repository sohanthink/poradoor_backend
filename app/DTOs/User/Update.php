<?php

namespace App\DTOs\User;

use App\Traits\DTOBasics;

class Update
{
    use DTOBasics;
    public function __construct(
            public string $name,
            public string $email,
            public string $number,
            public string $address = "",
    )
    {}
}
