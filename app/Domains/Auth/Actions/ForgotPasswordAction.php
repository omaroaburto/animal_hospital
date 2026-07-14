<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ForgotPasswordAction
{
    /**
     * Ejecuta el proceso de recuperación de contraseña.
     *
     * Este Action se encarga de:
     *
     * - Verificar si el usuario existe.
     * - Controlar la cantidad de solicitudes de recuperación
     *   permitidas por usuario.
     * - Aplicar un límite de seguridad mediante RateLimiter.
     * - Solicitar a Laravel la generación del token.
     * - Enviar la notificación personalizada de recuperación.
     *
     * La restricción de intentos evita abusos del endpoint
     * de recuperación de contraseña.
     *
     * @param string $email Correo electrónico asociado a la cuenta.
     *
     * @throws ValidationException Cuando el usuario supera
     *                             el límite permitido.
     */

    public function __invoke(string $email): void
    {
        /**
         * Busca el usuario asociado al correo recibido.
         *
         * Se realiza esta búsqueda para aplicar el límite
         * por usuario y no solamente por dirección de correo.
         */
        $user = User::where('email', $email)->first();

        /**
         * No se informa si el correo existe o no.
         *
         * Esto evita revelar información de usuarios válidos
         * y previene ataques de enumeración de cuentas.
         */
        if(!$user)
        {
            Password::sendResetLink([
                'email' => $email,
            ]);

            return;
        }

        /**
         * Genera una clave única para controlar
         * los intentos de recuperación del usuario.
         */
        $key = $this->getRateLimitKey($user);

        /**
         * Obtiene la configuración del límite desde config/auth_security.php.
         */
        $maxAttempts = config(
            'auth_security.password_reset.max_attempts'
        );


        $decaySeconds = config(
            'auth_security.password_reset.decay_seconds'
        );


        /**
         * Comprueba si el usuario alcanzó el máximo
         * de solicitudes permitidas.
         */
        if (RateLimiter::tooManyAttempts(
            $key,
            $maxAttempts
        )) {
            throw ValidationException::withMessages([
                'email' => [
                    'Has superado el límite de solicitudes de recuperación de contraseña.',
                ],
            ]);
        }

        /**
         * Registra un nuevo intento de recuperación.
         *
         * El contador expirará automáticamente después
         * del tiempo configurado.
         */
        RateLimiter::hit(
            $key,
            $decaySeconds
        );

        /**
         * Laravel genera el token de recuperación
         * y ejecuta el método personalizado:
         *
         * User::sendPasswordResetNotification()
         *
         * donde se envía ResetPasswordNotification.
         */
        Password::sendResetLink([
            'email' => $email,
        ]);
    }

    /**
     * Genera la clave utilizada por RateLimiter.
     *
     * El límite se aplica por usuario utilizando su ID.
     * De esta forma un usuario no puede evadir la restricción
     * cambiando formatos del correo.
     *
     * @param User $user Usuario que solicita recuperación.
     *
     * @return string Clave única del limitador.
     */
    private function getRateLimitKey(User $user): string
    {
        return "password-reset:{$user->id}";
    }
}
