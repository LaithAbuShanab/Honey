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

class Property extends Model implements Sortable, HasMedia
{
    use SortableTrait, HasSlug, HasTranslations, InteractsWithMedia , SoftDeletes;

    protected $table = 'properties';

    protected $fillable = [
        'name',
        'slug',
        'sort',
        'is_active',
    ];

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    public $translatable = ['name'];

    protected function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function property()
    {
        return $this->hasMany(PropertyValue::class);
    }
}
