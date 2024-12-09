<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'reason',
        'status_able_id',
        'status_able_type',
        'lookup_status_id'
    ];

    public function lookupStatus(): BelongsTo
    {
        return $this->belongsTo(LookupStatus::class);
    }

    public function statusAble(): MorphTo
    {
        return $this->morphTo();
    }
}
