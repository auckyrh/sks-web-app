<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Participant extends Model
{
    use SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Peserta')
            ->logOnly([
                'child_full_name', 'nickname', 'gender', 'birth_date',
                'grade', 'tshirt_size', 'allergies', 'notes',
                'parent_name', 'parent_whatsapp',
                'event_class_id', 'group_id',
            ])
            ->logOnlyDirty();
    }
    protected $fillable = [
        'registration_id', 'event_period_id', 'event_class_id', 'group_id',
        'child_full_name', 'nickname', 'gender', 'birth_date', 'grade',
        'parent_name', 'parent_whatsapp', 'tshirt_size', 'allergies', 'notes',
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

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
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
