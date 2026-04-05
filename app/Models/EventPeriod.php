<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class EventPeriod extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Periode Event')
            ->logOnly([
                'year', 'theme', 'is_active',
                'event_start_date', 'event_end_date',
                'registration_open_at', 'registration_close_at',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected $fillable = [
        'year', 'theme', 'event_logo', 'is_active',
        'event_start_date', 'event_end_date',
        'registration_open_at', 'registration_close_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'event_start_date' => 'date',
        'event_end_date' => 'date',
        'registration_open_at' => 'datetime',
        'registration_close_at' => 'datetime',
    ];

    public function eventClasses(): HasMany
    {
        return $this->hasMany(EventClass::class);
    }

    public function teams(): HasManyThrough
    {
        return $this->hasManyThrough(
            Team::class,
            EventClass::class,
            'event_period_id',
            'event_class_id',
            'id',
            'id'
        );
    }

    public function paymentTiers(): HasMany
    {
        return $this->hasMany(PaymentTier::class);
    }

    public function gatherings(): HasMany
    {
        return $this->hasMany(Gathering::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function publicPages(): HasMany
    {
        return $this->hasMany(PublicPage::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(EventContact::class);
    }

    public function committeeAssignments(): HasMany
    {
        return $this->hasMany(CommitteeAssignment::class);
    }

    protected static function booted(): void
    {
        // make sure only 1 period can be active
        static::saving(function ($period) {
            if ($period->is_active) {
                static::where('id', '!=', $period->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }
        });

        // Delete old event logo file when replaced or nulled
        static::updating(function ($period) {
            $old = $period->getOriginal('event_logo');
            $new = $period->event_logo;

            if ($old && $old !== $new) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($old);
            }
        });

        // Delete file when record is force deleted
        static::deleted(function ($period) {
            if ($period->event_logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($period->event_logo);
            }
        });
    }

}
