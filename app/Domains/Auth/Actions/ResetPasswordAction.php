<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Password;

class ResetPasswordAction
{
    public function __invoke(array $credentials): string
    {
        return Password::reset(
                    $credentials,
                    function (User $user, string $password) {
                        $user->forceFill([
                            'password' => $password,
                        ])->save();
                    }
        );
    }
}

