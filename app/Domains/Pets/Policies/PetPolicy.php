<?php

namespace App\Domains\Pets\Policies;

use App\Domains\Auth\Models\User;
use App\Domains\Pets\Models\Pet;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PetPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        if(!$user->is_active)
        {
            return Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        return ($user->role?->name === 'admin' || $user->role?->name === 'superadmin' )
                ? Response::allow()
                : Response::deny('No tienes permisos de \'superadmin\' o \'admin\' para ver el listado de mascotas.');
    }


    public function view(User $user, Pet $pet): Response
    {
        if(!$user->is_active)
        {
            return Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        if($user->role?->name === 'admin' || $user->role?->name === 'superadmin' )
        {
            return Response::allow();
        }

        return ($user->client?->id === $pet->client_id)
                ? Response::allow()
                : Response::deny('No tienes permisos para visualizar esta mascota.');
    }

    public function create(User $user): Response
    {
        if(!$user->is_active)
        {
            return Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }
        // Si quieres limitar por roles (Ej: solo admins, superadmins o clientes autorizados)
        $authorizedRoles = ['admin', 'superadmin', 'client'];

        if (!in_array($user->role?->name, $authorizedRoles))
        {
            return Response::deny('No tienes permisos para registrar nuevas mascotas.');
        }

        return Response::allow();
    }

    public function update(User $user, Pet $pet): Response
    {
        if(!$user->is_active)
        {
            return Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        if($user->role?->name === 'admin' || $user->role?->name === 'superadmin' )
        {
            return Response::allow();
        }

        return ($user->client?->id === $pet->client_id)
                ? Response::allow()
                : Response::deny('No tienes permisos para actualizar esta mascota.');
    }


    public function deactivate(User $user, Pet $pet): Response
    {
        if(!$user->is_active)
        {
            return Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        if(!$pet->is_active)
        {
            return Response::deny('La mascota solicitado ya está desactivada');
        }

        if($user->client?->id === $pet->client_id)
        {
            return Response::allow();
        }

        return ($user->role?->name === 'admin' || $user->role?->name === 'superadmin' )
                ? Response::allow()
                : Response::deny('No tienes permisos de \'superadmin\' o \'admin\' para desactivar la mascotas.');
    }


    public function restore(User $user, Pet $pet): Response
    {
        if(!$user->is_active)
        {
            return Response::deny("Su cuenta está desactivada, comuníquese con un administrador.");
        }

        if($pet->is_active)
        {
            return Response::deny('La mascota solicitado ya está activada');
        }

        if($user->client?->id === $pet->client_id)
        {
            return Response::allow();
        }

        return ($user->role?->name === 'admin' || $user->role?->name === 'superadmin' )
                ? Response::allow()
                : Response::deny('No tienes permisos de \'superadmin\' o \'admin\' para restaurar la mascotas.');
    }
}
