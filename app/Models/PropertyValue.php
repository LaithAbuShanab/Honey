<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class PropertyValue extends Model implements HasMedia
{
    use HasSlug, HasTranslations, InteractsWithMedia , SoftDeletes;

    protected $table = 'property_values';

    protected $fillable = [
        'property_id',
        'value',
        'slug',
        'is_active',
    ];

    public $translatable = ['value'];

    protected function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function () {
                return Str::random(8);
            })->saveSlugsTo('slug');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_property_values', 'property_value_id', 'product_id')
            ->withPivot('price_variation')
            ->withTimestamps();
    }
}
