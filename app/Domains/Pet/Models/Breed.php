<?php

namespace App\Domains\Pet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Breed extends Model
{
    protected $fillable = [
        'id',
        'name',
        'species_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }
}
