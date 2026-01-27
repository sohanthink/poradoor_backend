<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $guarded = ["id","created_at","updated_at"]; 
    public function product(): BelongsTo{
        return $this->belongsTo(related: Product::class);
    }
    public function user(): BelongsTo{
        return $this->belongsTo(related: User::class);
    }
}
