<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TshirtSize extends Model
{
    protected $fillable = [
        'event_period_id', 'code', 'label', 'category',
        'panjang', 'lebar', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function committeeAssignments(): HasMany
    {
        return $this->hasMany(CommitteeAssignment::class);
    }

    /** Human-readable dimensions string, e.g. "Panjang 43 cm, Lebar 32 cm" */
    public function getDimensionsLabelAttribute(): string
    {
        return "Panjang {$this->panjang} cm, Lebar {$this->lebar} cm";
    }
}
