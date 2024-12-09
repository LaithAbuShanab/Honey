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

class Lookup extends Model implements Sortable, HasMedia
{
    use SortableTrait, HasSlug, HasTranslations, InteractsWithMedia , SoftDeletes;

    protected $table = 'lookups';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'sort',
        'is_active',
    ];

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    protected function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public $translatable = ['title', 'description'];

    // parents
    public function parent()
    {
        return $this->belongsTo(lookup::class, 'parent_id');
    }

    // children
    public function children()
    {
        return $this->hasMany(lookup::class, 'parent_id');
    }
}
