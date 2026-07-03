<?php

namespace App\domains\Auth\Actions;
 
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutAction
{
    public function __invoke(): void{
        $token = JWTAuth::getToken();
        // Añadir el token a la lista negra (Blacklist) para que no se pueda reutilizar
        JWTAuth::invalidate($token);
    }
}
