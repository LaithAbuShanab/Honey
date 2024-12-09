<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends Model implements Sortable, HasMedia
{
    use SortableTrait, HasSlug, HasTranslations, InteractsWithMedia , SoftDeletes;

    protected $table = 'banners';

    protected $fillable = [
        'slug',
        'is_active',
        'title',
        'text',
        'button_text',
        'alignments',
        'button_link',
        'sort',
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

    public $translatable = ['title', 'text' , 'button_text'];
}
