<?php

namespace App\Domains\Auth\Policies;
 
use App\Domains\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    use HandlesAuthorization;
    /*************************************************
     *    $user es el usuario autentificado          *
     *    $adminTarget para preguntar si el usuario  *
     *   a ver o que se actualiza tiene rol de admin *
     *   ejemplo: ruta api/v1/admins/3               ***********
     *   el usuario solicitado con id 3 no tiene rol de admin  *********
     *   Por lo tanto no puede estar en operaciones de administradores *
     *******************************************************************/
   /* public function before(User $user): ?Response
    {
        if (!$user->is_active) {
            return Response::deny('Tu cuenta se encuentra inactiva. Comunícate con el administrador del sistema.');
        }
        return null;
    }*/
    public function viewAny(User $user): Response
    {
        return $user->role->name === "superadmin"
            ? Response::allow()
            : Response::deny('No tienes permisos de súper administrador para ver el listado de administradores.');
    }

    public function view(User $user, User $adminTarget): Response
    {
        if($adminTarget->role?->name !== 'admin'){
            return Response::deny('El usuario solicitado no pertenece al grupo de administradores.');
        }
        if($user->role->name === 'superadmin'){
            return Response::allow();
        }
        return $user->id === $adminTarget->id
            ? Response::allow()
            : Response::deny('No tienes permisos para ver la información de otros administradores');
    }

    public function createAdmin(User $user): Response
    {
        return $user->role->name === 'superadmin'
            ? Response::allow()
            : Response::deny('No tienes permisos para crear cuentas de administrador');
    }
    public function update(User $user, User $adminTarget): Response
    {
        if($adminTarget->role?->name !== 'admin'){
            return Response::deny('El usuario solicitado no pertenece al grupo de administradores.');
        }
        if($user->role->name === 'superadmin'){
            return Response::allow();
        }

        //pregunta si es usuario solicitanta es el usuario autentificado
        //                   y si es un usuario activo
        return ($user->id === $adminTarget->id)
            ? Response::allow()
            : Response::deny('No tienes permisos para actualizar la información de otros administradores');
    }
    public function delete(User $user, User $adminTarget): Response
    {
        if($adminTarget->role?->name !== 'admin'){
            return Response::deny('El usuario solicitado no pertenece al grupo de administradores.');
        }
        if(!$adminTarget->is_active){
            return Response::deny('El usuario solicitado ya está desactivado');
        }
        return $user->role->name === 'superadmin'
            ? Response::allow()
            : Response::deny('Necesitas permisos de superadmin para desactivar un administrador.');

    }
    public function restore(User $user, User $adminTarget): Response
    {
        if($adminTarget->role?->name !== 'admin'){
            return Response::deny('El usuario solicitado no pertenece al grupo de administradores.');
        }
        if($adminTarget->is_active){
            return Response::deny('El usuario solicitado ya está activado');
        }
        return $user->role->name === 'superadmin'
            ? Response::allow()
            : Response::deny('Necesitas permisos de superadmin para desactivar un administrador.');
    }
}
