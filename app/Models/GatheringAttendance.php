<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class GatheringAttendance extends Model
{
    use SoftDeletes;
    protected $fillable = ['gathering_id', 'user_id', 'attended', 'notes', 'recorded_by'];

    protected $casts = ['attended' => 'boolean'];

    public function gathering(): BelongsTo
    {
        return $this->belongsTo(Gathering::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
