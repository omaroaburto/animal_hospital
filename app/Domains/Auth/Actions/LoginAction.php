<?php

namespace App\domains\Auth\Actions;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    public function __invoke(array $credentials): array
    {
        if(!$token = JWTAuth::attempt($credentials)){
            throw ValidationException::withMessages([
                'email' => ['Usuario o contraseña incorrecta.'],
            ]);
        }

        return [
            'success'      => true,
            'message'      => 'El usuario ha iniciado sesión.',
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
