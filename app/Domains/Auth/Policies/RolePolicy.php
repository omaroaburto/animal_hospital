<?php

namespace App\domains\Auth\Policies;

use App\domains\Auth\Models\Role;
use App\domains\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;
    public function viewAny(User $user): Response
    {
        return $user->role->name === "admin"
            ? Response::allow()
            : Response::deny(' xxx No tienes permisos de administrador para listar los roles.');
    }

    public function view(User $user ): Response
    {
        return $user->role->name === "admin"
            ? Response::allow()
            : Response::deny('No tienes permisos de administrador para ver los roles.');
    }
    public function create(User $user): Response
    {
        return $user->role->name === "admin"
            ? Response::allow()
            : Response::deny('No tienes permisos de administrador para crear los roles.');
    }

    public function update(User $user, Role $role): Response
    {
        if($role->name === "admin"){
            return Response::deny("El admin no puede ser modificado");
        }
        return $user->role->name === "admin"
            ? Response::allow()
            : Response::deny('No tienes permisos de administrador para actualizar los roles.');
    }
}
