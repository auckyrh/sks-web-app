<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class GatheringRsvp extends Model
{
    use SoftDeletes;
    protected $fillable = ['gathering_id', 'user_id', 'will_attend', 'responded_at'];

    protected $casts = ['responded_at' => 'datetime'];

    public function gathering(): BelongsTo
    {
        return $this->belongsTo(Gathering::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
