<?php

namespace App\Domains\Auth\Actions;

use App\domains\Auth\Models\Role;

class UpdateRoleAction
{
    public function __invoke(array $validatedData, Role $role): Role
    {
        $role->update($validatedData);
        return $role;
    }
}
