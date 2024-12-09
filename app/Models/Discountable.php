<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discountable extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];  

    protected $table = 'discountables';

    protected $fillable = [
        'discount_id',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

}
