<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Gathering extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Pertemuan')
            ->logOnly(['name', 'date', 'location', 'notes', 'gathering_type_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
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
