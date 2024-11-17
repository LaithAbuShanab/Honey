<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class LookupStatus extends Model implements Sortable
{
    use SortableTrait, HasSlug, HasTranslations;

    protected $table = 'lookup_statuses';

    protected $fillable = [
        'name',
        'slug',
        'sort',
        'is_active',
        'bg_color',
        'font_color',
    ];

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    protected function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public $translatable = ['name'];
}
