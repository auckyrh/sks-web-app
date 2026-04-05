<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class EventClass extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Kelas Event')
            ->logOnly(['level', 'saint_name', 'grade_min', 'grade_max'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected $fillable = [
        'event_period_id', 'level', 'saint_name', 'grade_min', 'grade_max', 'logo'
    ];

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}
