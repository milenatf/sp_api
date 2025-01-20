<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailVerificationNotification extends Notification
{
    use Queueable;

    protected $hash;
    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $hash, string $password = null)
    {
        $this->hash = $hash;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = config('app.url_frontend') . "/verify/{$this->hash}";

        $mailMessage = (new MailMessage)
                    ->line('Verificação de email.')
                    ->action('Verificar email', url($url))
                    ->line('Obrigado por usar o SIM Pará!');

        if ($this->password !== null) {
            $mailMessage->line("Sua senha temporária é: {$this->password}. Para maior segurança, altere a sua senha.");
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
