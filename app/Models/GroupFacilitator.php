<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupFacilitator extends Model
{
    protected $fillable = [
        'group_id',
        'user_id',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Enforce: 1 facilitator → 1 group per event_period
    protected static function booted(): void
    {
        static::creating(function ($gf) {
            $alreadyAssigned = static::whereHas('group', fn($q) =>
            $q->where('event_period_id', $gf->group->event_period_id)
            )->where('user_id', $gf->user_id)->exists();

            if ($alreadyAssigned) {
                throw new \Exception('Pendamping sudah ditugaskan ke kelompok lain di periode ini.');
            }
        });
    }
}
