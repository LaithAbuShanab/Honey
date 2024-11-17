<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPropertyValue extends Model
{
    use SoftDeletes;

    protected $table = 'product_property_values';

    protected $fillable = [
        'product_id',
        'property_value_id',
        'price_variation',
    ];

    public function propertyValue()
    {
        return $this->belongsTo(PropertyValue::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
