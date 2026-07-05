<?php

namespace App\Domains\Auth\Actions;

use App\domains\Auth\Models\User;
use App\domains\Auth\Notifications\VerifyEmailNotification;

class SendVerificationEmailAction
{
    public function __invoke(User $user): void
    {
        //crea token de verificación de correo
        $token = $user->generateVerificationToken();
        $user->notify(new VerifyEmailNotification($token));
    }
}
