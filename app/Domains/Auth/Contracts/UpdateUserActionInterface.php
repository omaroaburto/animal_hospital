<?php
namespace App\Domains\Auth\Contracts;

use App\Domains\Auth\DTOs\UpdateUserDto;
use App\Domains\Auth\Models\User;

interface UpdateUserActionInterface{
    public function __invoke(UpdateUserDto $validatedData, User $user): User;
}
