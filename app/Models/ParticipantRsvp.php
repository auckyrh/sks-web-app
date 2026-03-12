<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParticipantRsvp extends Model
{
    use SoftDeletes;
    protected $fillable = ['participant_id', 'event_period_id', 'day', 'will_attend', 'updated_by'];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
