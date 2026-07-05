<?php

namespace App\Domains\Auth\Actions;

use App\domains\Auth\Models\User;
use RuntimeException;

class DeactivateUserAction
{
    public function __invoke(User $user): void 
    {
        // Si el método update devuelve false, disparamos el error de negocio
        if (!$user->update(['is_active' => false])) {
            throw new RuntimeException("No se pudo desactivar el usuario {$user->email}.");
        }
    }
}
