<?php

namespace App\Domains\Auth\Actions;

use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenAction
{
    public function __invoke(): array
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);

        //valida que la cuenta del usuario se encuentre activa.
        $user = JWTAuth::user();
        if(!$user || !$user->is_active){
            JWTAuth::invalidate($newToken);
            throw ValidationException::withMessages([
                'email' => ['Tu cuenta se encuentra inactiva. No puedes iniciar sesión.'],
            ]);
        }
        return [
            'success'      => true,
            'message'      => 'Se ha refrescado el token.',
            'access_token' => $newToken,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
