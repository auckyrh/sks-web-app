<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = [
        'event_period_id',
        'event_class_id',
        'number',
        'name',
    ];

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }

    public function eventClass(): BelongsTo
    {
        return $this->belongsTo(EventClass::class);
    }

    public function facilitators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_facilitators')
            ->withTimestamps();
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}