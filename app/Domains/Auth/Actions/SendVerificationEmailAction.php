<?php

namespace App\Domains\Auth\Actions;

use App\domains\Auth\Models\User;
use App\domains\Auth\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Notification;

class SendVerificationEmailAction
{
    public function __invoke(User $user): void
    {
        //crea token de verificación de correo
        $token = $user->generateVerificationToken();
        //$user->notify(new VerifyEmailNotification($token));
        /*
        |--------------------------------------------------------------------------
        | Cambio de correo
        |--------------------------------------------------------------------------
        |
        | Si existe pending_email significa que el usuario
        | está intentando cambiar su correo.
        |
        | La verificación debe enviarse al nuevo correo.
        |
        */
        if ($user->pending_email !== null) {

            Notification::route('mail', $user->pending_email)
                ->notify(
                    new VerifyEmailNotification(
                            $token,
                            $user->first_name
                        )
                );

            return;
        }

         /*
        |--------------------------------------------------------------------------
        | Registro normal
        |--------------------------------------------------------------------------
        |
        | En registro el correo válido es email.
        |
        */
        $user->notify(
            new VerifyEmailNotification(
                    $token,
                    $user->first_name
        ));
    }
}
