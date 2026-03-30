<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventContact extends Model
{
    protected $fillable = [
        'event_period_id', 'category', 'name', 'whatsapp', 'role', 'sort_order', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }
}
