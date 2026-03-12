<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lingkungan extends Model
{
    protected $fillable = ['wilayah_id', 'name'];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }
}
