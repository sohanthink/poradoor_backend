<?php

namespace App\DTOs\User;

class Update
{
    public function __construct(
            public string $name,
            public string $email,
            public string $number,
            public string $address = "",
    )
    {}
    public function toArray(): Array{
        return (array) $this;
    }
}
