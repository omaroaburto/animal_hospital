<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reset Protection
    |--------------------------------------------------------------------------
    |
    | Controla la cantidad de solicitudes de recuperación de contraseña
    | permitidas para un usuario dentro de un periodo determinado.
    |
    */

    'password_reset' => [

        /*
        | Cantidad máxima de solicitudes permitidas.
        */
        'max_attempts' => env(
            'PASSWORD_RESET_MAX_ATTEMPTS',
            3
        ),


        /*
        | Tiempo en segundos que dura el bloqueo.
        | Por defecto: 24 horas.
        */
        'decay_seconds' => env(
            'PASSWORD_RESET_DECAY_SECONDS',
            86400
        ),
    ],

];
