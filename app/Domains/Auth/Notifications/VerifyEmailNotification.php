<?php

namespace App\Domains\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends Notification
{
    use Queueable;


    public function __construct(
        public string $token,
        public ?string $name = null
    ) {}


    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }


    public function toMail(mixed $notifiable): MailMessage
    {
        $url = config('app.frontend_url') . '?token=' . $this->token;


        return (new MailMessage)
            ->subject('Verifica tu cuenta en Animal Hospital')
            ->view('emails.verify-notification', [
                'url' => $url,
                'name' => $this->name ?? 'Usuario',
            ]);
    }
}
