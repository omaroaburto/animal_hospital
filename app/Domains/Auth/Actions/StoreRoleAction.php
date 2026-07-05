<?php

namespace App\Domains\Auth\Actions;

use App\domains\Auth\Models\Role;

class StoreRoleAction
{
    public function __invoke(array $validatedData): Role
    {
        return Role::create($validatedData);
    }
}
