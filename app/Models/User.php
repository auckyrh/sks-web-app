<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'phone', 'role', 'photo'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function panitiaAssignments(): HasMany
    {
        return $this->hasMany(PanitiaAssignment::class);
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(PanitiaAssignment::class)
            ->whereHas('eventPeriod', fn($q) => $q->where('is_active', true));
    }

    public function isSuperAdmin(): bool { return $this->role === 'superadmin'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isMember(): bool { return $this->role === 'member'; }

}
