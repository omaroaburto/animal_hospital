<?php

namespace App\Domains\Client\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Client\Enums\DocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_type',
        'document_number',
        'notes',
        'secondary_phone',
        'street',
        'number',
        'apartment',
        'commune_id',
        'user_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function newFactory(): Factory
    {
        return ClientFactory::new();
    }

    protected function casts(): array
    {
        return [
            'document_type' => DocumentType::class
        ];
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
