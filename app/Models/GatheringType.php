<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GatheringType extends Model
{
    protected $fillable = ['slug', 'label', 'color', 'order'];

    public function gatherings(): HasMany
    {
        return $this->hasMany(Gathering::class);
    }
}
