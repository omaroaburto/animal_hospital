<?php

namespace App\domains\Auth\Actions;

use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenAction
{
    public function __invoke(): array {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);
        return [
            'success'      => true,
            'message'      => 'Se ha refrescado el token.',
            'access_token' => $newToken,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
