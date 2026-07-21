<?php

namespace App\Domains\Pet\Models;

use App\Domains\Pet\Enums\Gender;
use App\Domains\Client\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\PetFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'client_id',
        'breed_id',
        'gender',
        'microchip',
        'microchip_number',
        'birth_date',
        'death_date',
        'color',
        'sterilized',
        'photo_url',
        'photo_id',
        'notes',
        'is_active'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function casts(): array
    {
        return [
            'gender'     => Gender::class,
            'birth_date' => 'immutable_date',
            'death_date' => 'immutable_date',
            'microchip'  => 'boolean',
            'sterilized' => 'boolean',
            'is_active'  => 'boolean'
        ];
    }
    protected static function newFactory(): Factory
    {
        return PetFactory::new();
    }

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
