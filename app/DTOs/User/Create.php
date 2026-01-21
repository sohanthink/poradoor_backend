<?php

namespace App\DTOs\User;

class Create
{
    public function __construct(
            public string $name,
            public string $email,
            public string $password,
            public string $number,
            public string $address = "",
    )
    {}
    public function toArray(): Array{
        return (array) $this;
    }
}
