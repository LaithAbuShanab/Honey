<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountApplication extends Model
{
    protected $table = 'discount_applications';

    protected $fillable = [
        'discount_id',
        'user_id',
        'applied_at',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
