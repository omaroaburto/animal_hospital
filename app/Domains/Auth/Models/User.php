<?php

namespace App\Domains\Auth\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'avatar_url',
        'avatar_id',
        'is_active',
        'last_login_at',
        'email_verified_at',
        'verification_token',
        'role_id'
    ];
    protected $hidden = [
        'password',
        'verification_token',
        'last_login_at',
        'created_at',
        'updated_at',
        'deleated_at'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo{
        return $this->belongsTo(Role::class);
    }
    /*************************************
     *            factory                *
     *************************************/

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }
    /*************************************
     *                JWT                *
     *************************************/
    public function getJWTIdentifier(): int | string
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims():array
    {
        return [];
    }

    /******************************
     *   Verificación de correo   *
     ******************************/
    public function generateVerificationToken(): string
    {
        $token = Str::random(64);

        $this->update([
            'verification_token' => $token,
        ]);

        return $token;
    }

    public function markEmailAsVerified(): void
    {
        $this->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);
    }

    public function hasVerifiedEmailCustom(): bool
    {
        return !is_null($this->email_verified_at);
    }
}
