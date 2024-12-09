<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;

    protected $table = 'discounts';
    
    protected $fillable = [
        'discount_type',
        'type',
        'amount',
        'start_date',
        'end_date',
        'code',
        'min_purchase',
        'max_discount',
        'limit_per_user',
        'is_active',
    ];

    public function discountables()
    {
        return $this->hasMany(Discountable::class);
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'discountable');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'discountable');
    }
}
