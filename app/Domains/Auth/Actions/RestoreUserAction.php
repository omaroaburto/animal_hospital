<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Models\User;
use RuntimeException;

class RestoreUserAction
{
    public function __invoke(User $user): void
    {
        // Si el método update devuelve false, disparamos el error de negocio
        if (!$user->update(['is_active' => true])) {
            throw new RuntimeException("No se pudo restaurar el usuario {$user->email}.");
        }
    }
}
