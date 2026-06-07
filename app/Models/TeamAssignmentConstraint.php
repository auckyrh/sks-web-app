<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamAssignmentConstraint extends Model
{
    protected $fillable = [
        'event_period_id',
        'type',
        'registration_numbers',
        'fixed_team_id',
        'notes',
    ];

    protected $casts = [
        'registration_numbers' => 'array',
    ];

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }

    public function fixedTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'fixed_team_id');
    }
}
