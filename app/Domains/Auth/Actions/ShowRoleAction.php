<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Models\Role; 

class ShowRoleAction
{
    public function __invoke(string $identifier): Role
    {
        $role = Role::where('id', $identifier)
                    ->orWhere('name',$identifier)
                    ->firstOrFail();
        return $role;
    }
}