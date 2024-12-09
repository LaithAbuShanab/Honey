<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements Sortable, HasMedia
{
    use SortableTrait, HasSlug, HasTranslations, InteractsWithMedia, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'slug',
        'sort',
        'quantity',
        'price',
        'cost_price',
        'rate',
        'rate_counter',
        'is_active',
    ];

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    public $translatable = ['name', 'description'];

    protected function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ProductPropertyValue()
    {
        return $this->hasMany(ProductPropertyValue::class, 'product_id');
    }

    public function raters()
    {
        return $this->belongsToMany(User::class, 'product_rates')
            ->withPivot('rate', 'review')
            ->withTimestamps();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function discounts()
    {
        return $this->morphMany(Discountable::class, 'discountable');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
