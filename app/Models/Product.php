<?php

namespace App\Models;

use App\Models\Category;
use App\Traits\ModelBasics;
use Spatie\Sluggable\HasSlug;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasSlug, ModelBasics;
    protected $guarded = ["id","created_at","updated_at"]; 
    public function category(): BelongsTo{
        return $this->belongsTo(related: Category::class);
    }
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
