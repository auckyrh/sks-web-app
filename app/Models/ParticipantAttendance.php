<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParticipantAttendance extends Model
{
    use SoftDeletes;
    protected $fillable = ['participant_id', 'event_period_id', 'day', 'attended', 'recorded_by'];

    protected $casts = ['attended' => 'boolean'];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
