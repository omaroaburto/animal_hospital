<?php

namespace App\Domains\Auth\Actions;

use App\domains\Auth\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class IndexRoleAction
{
    public function __invoke(): Collection
    {
        return Role::all();
    }
}
