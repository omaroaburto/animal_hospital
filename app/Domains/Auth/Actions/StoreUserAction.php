<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Contracts\StoreUserActionInterface;
use App\Domains\Auth\DTOs\CreateUserDto;
use App\Domains\Auth\Exceptions\RoleNotFoundException;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;

class StoreUserAction implements StoreUserActionInterface
{
    public function __invoke(CreateUserDto $validatedData, string $roleName): User
    {
        //valida que exista el rol
        if(!$role = Role::where('name', $roleName)->first()){
            throw new RoleNotFoundException("El rol '{$roleName}' no está registrado.");
        }
        //se crea la cuenta usuario
        $user =  User::create([
            ...$validatedData->toArray(),
            'role_id' => $role,
            'is_active' => true
        ]);
        return $user;
    }
}
