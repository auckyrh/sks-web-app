<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'event_period_id', 'registration_number', 'child_full_name', 'nickname',
        'gender', 'birth_date', 'address', 'wilayah_id', 'lingkungan_id',
        'grade', 'registration_source', 'has_joined_biak_yck', 'tshirt_size',
        'parent_name', 'parent_wa', 'allergies', 'notes',
        'payment_proof_path', 'payment_tier_id', 'payment_amount',
        'payment_status', 'verified_by', 'verified_at', 'status',
        'created_by', 'deleted_by'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'has_joined_biak_yck' => 'boolean',
        'verified_at' => 'datetime',
        'payment_amount' => 'integer',
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

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function participant(): HasOne
    {
        return $this->hasOne(Participant::class);
    }

// Auto-generate registration number
    protected static function booted(): void
    {
        static::creating(function ($registration) {
            $year = now()->year;
            $count = static::whereYear('created_at', $year)->count() + 1;
            $registration->registration_number = 'SKS-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        });
    }
}
