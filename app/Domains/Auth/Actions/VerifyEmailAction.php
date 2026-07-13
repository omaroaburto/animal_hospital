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

        /*
        |--------------------------------------------------------------------------
        | Confirmación de correo
        |--------------------------------------------------------------------------
        |
        | Si existe pending_email:
        |   pending_email -> email
        |
        | Si no existe:
        |   solo marca email como verificado
        |
        */

        $user->markEmailAsVerified();


        return $user->refresh();
    }
}
