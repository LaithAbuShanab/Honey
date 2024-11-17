<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class Type extends Model
{
    use HasTranslations , HasSlug;

    protected $table = 'types';

    protected $fillable = [
        'name',
        'slug',
    ];

    public $translatable = [
        'name',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
