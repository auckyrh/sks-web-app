<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaymentTier extends Model
{
    protected $fillable = [
        'event_period_id', 'name', 'amount', 'valid_from', 'valid_until'
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }
}
