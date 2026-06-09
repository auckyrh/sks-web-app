<?php

namespace App\Models;

use App\Support\PhoneNormalizer;
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
        'registration_id', 'event_period_id', 'event_class_id', 'team_id', 'group_id',
        'child_full_name', 'nickname', 'gender', 'birth_date', 'grade',
        'parent_name', 'parent_whatsapp', 'tshirt_size', 'tshirt_size_id', 'allergies', 'notes',
        'created_by', 'deleted_by'
    ];

    public function setParentWhatsappAttribute(string $value): void
    {
        $this->attributes['parent_whatsapp'] = PhoneNormalizer::normalize($value);
    }

    protected $casts = ['birth_date' => 'date'];

    protected static function booted(): void
    {
        // Sync tshirt_size_id whenever tshirt_size string is set
        static::saving(function ($participant) {
            if ($participant->isDirty('tshirt_size') && $participant->event_period_id && $participant->tshirt_size) {
                $participant->tshirt_size_id = TshirtSize::where('event_period_id', $participant->event_period_id)
                    ->where('code', $participant->tshirt_size)
                    ->value('id');
            }
        });
    }

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

    public function tshirtSize(): BelongsTo
    {
        return $this->belongsTo(TshirtSize::class);
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
