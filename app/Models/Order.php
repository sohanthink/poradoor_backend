<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function order_items(): HasMany{
        return $this->hasMany(related: OrderItem::class);
    }
}
