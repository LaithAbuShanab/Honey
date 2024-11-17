<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    use SoftDeletes;
    
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'district',
        'address',
        'building_number',
        'email',
        'phone',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
