<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EventClass extends Model
{
    protected $fillable = [
        'event_period_id', 'level', 'saint_name', 'grade_min', 'grade_max'
    ];

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}
