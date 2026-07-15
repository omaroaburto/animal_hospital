<?php

namespace App\Domains\Pets\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\HasMany;

class Species extends Model
{

    protected $fillable = [
        'id',
        'name',
        'scientific_name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function breeds(): HasMany
    {
        return $this->hasMany(Breed::class);
    }
}
