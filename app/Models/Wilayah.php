<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wilayah extends Model
{
    protected $fillable = ['name'];

    public function lingkungan(): HasMany
    {
        return $this->hasMany(Lingkungan::class);
    }
}
