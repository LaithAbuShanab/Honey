<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model implements Sortable
{
    use SortableTrait, HasSlug, HasTranslations , SoftDeletes;

    protected $table = 'tags';

    protected $fillable = [
        'name',
        'slug',
        'sort',
        'is_active'
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

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tags', 'tag_id', 'blog_id')->withTimestamps();
    }
}
