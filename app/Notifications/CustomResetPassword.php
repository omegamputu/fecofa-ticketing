<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    protected $token;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
        
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
        return (new MailMessage)
            ->subject('Invitation à FECOFA Ticketing')
            ->line('Bonjour ' . $notifiable->name)
            ->line('Vous avez été invité à utiliser l\'application de gestion des tickets de la FECOFA.')
            ->line('Cliquez sur le bouton ci-dessous pour définir votre mot de passe et activer votre compte.')
            ->action('Définir mot mot de passe', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Ce lien expirera dans '. config('auth.passwords.'. config('auth.defaults.passwords'). '.expire'). ' minutes.')
            ->line('Si vous n\'avez pas demandé cet accès, ignorez cet email.');
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
