<?php

namespace App\Models;

use App\Traits\ModelBasics;
use Spatie\Sluggable\HasSlug;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia, HasSlug, ModelBasics;
    protected $guarded = ["id","created_at","updated_at"]; 

    public function subcategories(): HasMany{
        return $this->hasMany(related: Category::class,foreignKey: 'parent_id');
    }
    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
