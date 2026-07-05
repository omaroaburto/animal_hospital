<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Exceptions\RoleNotFoundException;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User; 

class StoreUserAction
{
    public function __invoke(array $validatedData, string $roleName): User
    {
        //valida que exista el rol
        if(!$role = Role::where('name', $roleName)->first()){
            throw new RoleNotFoundException("El rol '{$roleName}' no está registrado.");
        }
        $validatedData['role_id'] = $role->id;
        $validatedData['is_active'] = true;
        //se crea la cuenta del administrador
        $user =  User::create($validatedData);
        return $user;
    }
}
