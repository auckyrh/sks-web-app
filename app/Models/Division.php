<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Division extends Model
{
    protected $fillable = ['name', 'access_level'];

    public function committeeAssignments(): HasMany
    {
        return $this->hasMany(CommitteeAssignment::class);
    }
}
