<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gathering extends Model
{
    protected $fillable = [
        'event_period_id', 'gathering_type_id', 'name', 'date', 'location', 'notes'
    ];

    protected $casts = ['date' => 'datetime'];

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }

    public function gatheringType(): BelongsTo
    {
        return $this->belongsTo(GatheringType::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(GatheringRsvp::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(GatheringAttendance::class);
    }
}
