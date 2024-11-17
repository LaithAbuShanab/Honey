<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes  , HasTranslations;

    protected $table = 'questions';

    protected $fillable = [
        'product_id',
        'question',
        'answer',
    ];

    public $translatable = ['question', 'answer'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
