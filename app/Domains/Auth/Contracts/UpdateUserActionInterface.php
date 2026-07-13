<?php
namespace App\Domains\Auth\Contracts;

use App\Domains\Auth\DTOs\UpdateUserDto;
use App\Domains\Auth\Models\User;
use Illuminate\Http\UploadedFile;

interface UpdateUserActionInterface{
    public function __invoke(
        UpdateUserDto $validatedData,
        User $user,
        ?UploadedFile $avatarFile = null
    ): User;
}
