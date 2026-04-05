<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class PaymentTier extends Model
{
    use LogsActivity;

    protected $fillable = [
        'event_period_id', 'name', 'amount', 'valid_from', 'valid_until'
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Tier Pembayaran')
            ->logOnly(['name', 'amount', 'valid_from', 'valid_until'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }
}
