<?php

namespace App\Traits;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;

trait ModelBasics{
    public function scopeActive(Builder $query): Builder{
        return $query->where(column: 'status', operator: Status::PUBLIC);
    }
}