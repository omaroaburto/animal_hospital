<?php

namespace App\Domains\Client\Policies;

use App\Domains\Auth\Models\User;
use App\Domains\Client\Models\Client;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
    use HandlesAuthorization;
    public function viewAny(User $user): Response
    {
        if (!$user->is_active) {
            Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        return ($user->role->name === 'superadmin' || $user->role->name === 'admin')
            ? Response::allow()
            : Response::deny('No tienes permisos de \'superadmin\' o \'admin\' para ver el listado de clientes.');
    }
    public function view(User $user, Client $client): Response
    {
        if ($user->role->name === 'superadmin' || $user->role->name === 'admin') {
            return Response::allow();
        }

        if (!$user->is_active) {
            Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        return ($user->id === $client->user->id)
            ? Response::allow()
            : Response::deny('No tienes permisos para ver este perfil de usuario');
    }
    public function update(User $user, Client $client): Response
    {
        if ($user->role->name === 'superadmin' || $user->role->name === 'admin') {
            return Response::allow();
        }

        if (!$user->is_active) {
            Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        return ($user->id === $client->user->id)
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar los datos de este perfil.');
    }
    public function delete(User $user, Client $client): Response
    {
        if (!$user->is_active) {
            Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        return ($user->role->name === 'superadmin' || $user->role->name === 'admin')
            ? Response::allow()
            : Response::deny('No tienes permisos de \'superadmin\' o \'admin\' para desactivar una cuenta de un clientes.');
    }
    public function restore(User $user, Client $client): Response
    {
        if (!$user->is_active) {
            Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        return ($user->role->name === 'superadmin' || $user->role->name === 'admin')
            ? Response::allow()
            : Response::deny('No tienes permisos de \'superadmin\' o \'admin\' para restaurar una cuenta de un clientes.');
    }
}
