<?php

namespace App\Domains\Clients\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\RegionFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{

    protected $fillable = [
        'name'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class);
    }
}
