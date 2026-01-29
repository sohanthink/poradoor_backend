<?php

namespace App\Traits;

trait DTOBasics{
    public function to_array(): Array{
        return (array) $this;
    }
}