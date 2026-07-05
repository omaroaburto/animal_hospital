<?php

namespace App\Domains\Auth\Actions;

use App\domains\Auth\Models\User;

class UpdateUserAction
{
    public function __invoke(array $validatedData, User $user): User
    {
        $user->update($validatedData);
        return $user;
    }
}
