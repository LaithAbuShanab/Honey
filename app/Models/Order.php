<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'discount_id',
        'type_id',
        'amount',
        'copon_discount_amount',
        'total_tax_amount',
        'transaction_reference',
        'order_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'copon_discount_amount' => 'decimal:2',
        'total_tax_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function statuses(): MorphMany
    {
        return $this->morphMany(Status::class, 'status_able');
    }
}
