<?php

namespace App\Domains\Auth\Actions;

use App\domains\Auth\Models\User;
use Illuminate\Validation\ValidationException;

class VerifyEmailAction
{
    public function __invoke(array $validatedData): User
    {
        $user = User::where('verification_token', $validatedData['token'])->first();
        
        if (!$user) {
            throw ValidationException::withMessages([
                'token' => 'Token inválido o expirado'
            ]);
        }

        $user->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);
        return $user;
    }
}
