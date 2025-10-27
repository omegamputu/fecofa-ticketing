<?php

namespace App\Notifications\Ticket;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCreatedNotification extends Notification
{
    use Queueable;

    public Ticket $ticket;
    public $author;

    /**
     * Create a new notification instance.
     */
    public function __construct($ticket, $author)
    {
        //
        $this->ticket = $ticket;
        $this->author = $author; // l'utilisateur (demandeur) qui a créé le ticket
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'ticket_created',
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject ? $this->ticket->subject : '(sans sujet)',
            'priority' => $this->ticket->priority ?? null,
            'status' => $this->ticket->status ?? null,
            'created_by' => $this->author?->name,
            'message' => "{$this->author?->name} a créé un nouveau ticket : \"({$this->ticket->subject})\".",
        ];
    }
}
