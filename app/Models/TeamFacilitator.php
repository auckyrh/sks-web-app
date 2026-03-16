<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamFacilitator extends Model
{
    protected $fillable = ['team_id', 'user_id'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($tf) {
            $alreadyAssigned = static::whereHas('team', fn($q) =>
            $q->where('event_period_id', $tf->team->event_period_id)
            )->where('user_id', $tf->user_id)->exists();

            if ($alreadyAssigned) {
                throw new \Exception('Pendamping sudah ditugaskan di kelompok lain di periode ini.');
            }
        });
    }
}