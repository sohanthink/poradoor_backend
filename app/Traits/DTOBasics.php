<?php

namespace App\Traits;

trait DTOBasics{
    public function toArray(): Array{
        return (array) $this;
    }
}