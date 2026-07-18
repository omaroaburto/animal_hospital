<?php

namespace App\Domains\Auth\Policies;

use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;
    public function viewAny(User $user): Response
    {
        return $user->role->name === "superadmin"
            ? Response::allow()
            : Response::deny(' xxx No tienes permisos de súper administrador para listar los roles.');
    }

    public function viewRole(User $user ): Response
    {
        return $user->role->name === "superadmin"
            ? Response::allow()
            : Response::deny('No tienes permisos de súper administrador para ver los roles.');
    }
    public function create(User $user): Response
    {
        return $user->role->name === "superadmin"
            ? Response::allow()
            : Response::deny('No tienes permisos de súper administrador para crear los roles.');
    }

    public function update(User $user, Role $role): Response
    {
        if($role->name === "superadmin")
        {
            return Response::deny("El súper admininistrador no puede ser modificado");
        }
        
        return $user->role->name === "superadmin"
            ? Response::allow()
            : Response::deny('No tienes permisos de súper administrador para actualizar los roles.');
    }
}
