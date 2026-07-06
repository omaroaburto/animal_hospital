<?php
namespace App\Domains\Auth\Contracts;

use App\Domains\Auth\DTOs\CreateUserDto;
use App\Domains\Auth\Models\User;

interface StoreUserActionInterface{
    public function __invoke(CreateUserDto $validatedData, string $roleName ): User;
}
