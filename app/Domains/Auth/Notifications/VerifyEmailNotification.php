<?php

namespace App\Domains\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends Notification
{
    use Queueable;
    public function __construct(public string $token) {}

    public function via(mixed $notifiable): array {
        return ['mail'];
    }
    public function toMail(mixed $notifiable): MailMessage
    {
        $url = config('app.frontend_url') . '?token=' . $this->token;
        /*
        return (new MailMessage)
            ->subject('Verifica tu cuenta en Animal Hospital')
            ->greeting('¡Bienvenido!')
            ->line('Gracias por registrarte. Solo falta un paso.')
            ->action('Verificar cuenta', $url)
            ->line('Si no creaste esta cuenta, puedes ignorar este correo.');*/
         return (new MailMessage)
            ->subject('Verifica tu cuenta en Animal Hospital')
            ->view('emails.verify-notification', [
                'url' => $url,
                'name' => $notifiable->first_name // $notifiable es el usuario que recibe el correo
            ]);
    }
}
/*
<?php

namespace App\domains\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function __construct(public string $token) {}

    public function via(mixed $notifiable): array 
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        // 1. Construimos la URL apuntando a la ruta específica de verificación en tu Frontend
        $frontendUrl = rtrim(config('app.frontend_url'), '/');
        $url = "{$frontendUrl}/email-verification?token=" . $this->token;

        // 2. Retornamos el mensaje inyectando las variables a tu plantilla Blade personalizada
        return (new MailMessage)
            ->subject('Verifica tu cuenta en Animal Hospital')
            ->view('emails.verify-notification', [
                'url' => $url,
                'name' => $notifiable->first_name // Cambiado a 'first_name' según tu modelo User
            ]);
    }
}
 */
