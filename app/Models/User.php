<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['full_name', 'nick_name', 'email', 'password', 'phone', 'role', 'photo', 'birth_date', 'address', 'wilayah_id'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function committeeAssignments(): HasMany
    {
        return $this->hasMany(CommitteeAssignment::class);
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(CommitteeAssignment::class)
            ->whereHas('eventPeriod', fn($q) => $q->where('is_active', true));
    }

    public function facilitatingGroups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_facilitators')
            ->withTimestamps();
    }

    public function getFilamentName(): string
    {
        return $this->full_name;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
//        return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }

    public function isSuperAdmin(): bool { return $this->role === 'superadmin'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isMember(): bool { return $this->role === 'member'; }

    protected static function booted(): void
    {
        static::updating(function ($user) {
            $old = $user->getOriginal('photo');
            $new = $user->photo;

            if ($old && $old !== $new) {
                Storage::disk('public')->delete($old);
            }
        });

        static::forceDeleted(function ($user) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
        });
    }
}
