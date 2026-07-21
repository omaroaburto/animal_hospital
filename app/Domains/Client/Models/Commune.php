<?php

namespace App\Domains\Client\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commune extends Model
{
    protected $fillable = [
        'name',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
