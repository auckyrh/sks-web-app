<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'registration_id', 'event_period_id', 'event_class_id',
        'child_full_name', 'nickname', 'gender', 'birth_date', 'grade',
        'parent_name', 'parent_wa', 'tshirt_size', 'allergies', 'notes',
        'created_by', 'deleted_by'
    ];

    protected $casts = ['birth_date' => 'date'];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }

    public function eventClass(): BelongsTo
    {
        return $this->belongsTo(EventClass::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(ParticipantRsvp::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(ParticipantAttendance::class);
    }
}
