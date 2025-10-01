<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketResolvedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Ticket $ticket)
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
            ->subject("Votre ticket #{$this->ticket->id} est résolu")
            ->greeting('Bonjour '.$notifiable->name)
            ->line('Votre demande a été résolue.')
            ->line('Sujet : '.$this->ticket->subject)
            ->line('Note : '.($this->ticket->resolution_note ?: '—'))
            ->action('Voir le ticket', url(route('tickets.show', $this->ticket)))
            ->line("Merci d’utiliser FECOFA Ticketing.");
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
