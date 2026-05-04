<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Registration extends Model
{
    use SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Registrasi')
            ->logOnly([
                // Data anak
                'child_full_name', 'nickname', 'gender', 'birth_date', 'address',
                'grade', 'tshirt_size', 'allergies', 'notes',
                'wilayah_id', 'lingkungan_id', 'registration_source', 'has_joined_biak_yck',
                // Data orang tua
                'parent_name', 'parent_whatsapp',
                // Pembayaran
                'payment_tier_id', 'payment_amount', 'donation_amount',
                'payment_date', 'payer_name', 'payment_proof_path',
                'payment_status', 'payment_verified_by', 'payment_verified_at', 'rejection_reason',
                // Status registrasi
                'status', 'registration_verified_by', 'registration_verified_at',
            ])
            ->logOnlyDirty();
    }
    public function activities(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\Spatie\Activitylog\Models\Activity::class, 'subject');
    }
    protected $fillable = [
        'event_period_id', 'registration_number', 'child_full_name', 'nickname',
        'gender', 'birth_date', 'address', 'wilayah_id', 'lingkungan_id',
        'grade', 'registration_source', 'has_joined_biak_yck', 'tshirt_size', 'tshirt_size_id',
        'parent_name', 'parent_whatsapp', 'allergies', 'notes',
        'payment_proof_path', 'payer_name', 'payment_date', 'payment_tier_id', 'payment_amount', 'donation_amount',
        'payment_status', 'payment_verified_by', 'payment_verified_at',
        'rejection_reason',
        'status', 'registration_verified_by', 'registration_verified_at',
        'created_by', 'deleted_by'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'payment_date' => 'date',
        'has_joined_biak_yck' => 'boolean',
        'payment_verified_at' => 'datetime',
        'registration_verified_at' => 'datetime',
        'payment_amount' => 'integer',
        'donation_amount' => 'integer',
    ];

    public function eventPeriod(): BelongsTo
    {
        return $this->belongsTo(EventPeriod::class);
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function lingkungan(): BelongsTo
    {
        return $this->belongsTo(Lingkungan::class);
    }

    public function paymentTier(): BelongsTo
    {
        return $this->belongsTo(PaymentTier::class);
    }

    public function paymentVerifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payment_verified_by');
    }

    public function registrationVerifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registration_verified_by');
    }

    public function tshirtSize(): BelongsTo
    {
        return $this->belongsTo(TshirtSize::class);
    }

    public function participant(): HasOne
    {
        return $this->hasOne(Participant::class);
    }

// Auto-generate registration number
    protected static function booted(): void
    {
        // Sync tshirt_size_id whenever tshirt_size string is set
        static::saving(function ($registration) {
            if ($registration->isDirty('tshirt_size') && $registration->event_period_id && $registration->tshirt_size) {
                $registration->tshirt_size_id = TshirtSize::where('event_period_id', $registration->event_period_id)
                    ->where('code', $registration->tshirt_size)
                    ->value('id');
            }
        });

        // Generate Registration Number after user submit the registration form
        static::creating(function ($registration) {
            $year = now()->year;
            $count = static::whereYear('created_at', $year)->count() + 1;
            $registration->registration_number = 'SKS-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        });

        // Delete old payment proof file when replaced or nulled
        static::updating(function ($registration) {
            $old = $registration->getOriginal('payment_proof_path');
            $new = $registration->payment_proof_path;

            if ($old && $old !== $new) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($old);
            }

            // Auto-stamp or clear verified_by / verified_at when status changes
            if ($registration->isDirty('payment_status')) {
                if ($registration->payment_status === 'verified' && ! $registration->payment_verified_at) {
                    $registration->payment_verified_by = auth()->id();
                    $registration->payment_verified_at = now();
                } elseif ($registration->payment_status !== 'verified') {
                    $registration->payment_verified_by = null;
                    $registration->payment_verified_at = null;
                }
            }

            if ($registration->isDirty('status')) {
                if ($registration->status === 'confirmed' && ! $registration->registration_verified_at) {
                    $registration->registration_verified_by = auth()->id();
                    $registration->registration_verified_at = now();
                } elseif ($registration->status !== 'confirmed') {
                    $registration->registration_verified_by = null;
                    $registration->registration_verified_at = null;
                }
            }
        });

        // Delete file when record is force deleted
        static::forceDeleted(function ($registration) {
            if ($registration->payment_proof_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($registration->payment_proof_path);
            }
        });
    }


}
