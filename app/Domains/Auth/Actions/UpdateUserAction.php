<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Contracts\UpdateUserActionInterface;
use App\Domains\Auth\DTOs\UpdateUserDto;
use App\domains\Auth\Models\User;

class UpdateUserAction implements UpdateUserActionInterface
{
    public function __invoke(UpdateUserDto $validatedData, User $user): User
    {
        $user->update($validatedData->toArray());
        return $user->refresh();
    }
}
