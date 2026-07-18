<?php

namespace App\Domains\Pets\Policies;

use App\Domains\Auth\Models\User;
use App\Domains\Pets\Models\Species;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SpeciesPolicy
{
    use HandlesAuthorization;
    public function create(User $user): Response
    {
        if(!$user->is_active){
           return Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        return ($user->role?->name === 'admin' || $user->role?->name === 'superadmin' )
                ? Response::allow()
                : Response::deny('No tienes permisos de \'superadmin\' o \'admin\' para crear una especie.');
    }
    public function update(User $user, Species $species): Response
    {
        if(!$user->is_active){
            return Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }

        return ($user->role?->name === 'admin' || $user->role?->name === 'superadmin' )
                ? Response::allow()
                : Response::deny('No tienes permisos de \'superadmin\' o \'admin\' para actualizar una especie.');
    }
    public function delete(User $user, Species $species): Response
    {
        if(!$user->is_active){
            return Response::deny('Su cuenta está desactivada, comuníquese con un administrador.');
        }
        
        return ($user->role?->name === 'admin' || $user->role?->name === 'superadmin' )
                ? Response::allow()
                : Response::deny('No tienes permisos de \'superadmin\' o \'admin\' para eliminar una especie.');
    }
}
