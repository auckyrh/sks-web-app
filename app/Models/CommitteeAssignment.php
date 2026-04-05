<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class CommitteeAssignment extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Penugasan Komite')
            ->logOnly(['user_id', 'division_id', 'position', 'is_active'])
            ->logOnlyDirty();
    }
    protected $table = 'committee_assignments';

    protected $fillable = [
        'user_id', 'event_period_id', 'division_id', 'position', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function isUpperDivision(): bool
    {
        return $this->division->access_level === 'upper';
    }
}
