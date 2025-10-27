<?php

namespace App\Notifications\Ticket;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketAssignedNotification extends Notification
{
    use Queueable;

    public Ticket $ticket;
    public $assignedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct($ticket, $assignedBy)
    {
        //
        $this->ticket = $ticket;
        $this->assignedBy = $assignedBy; // l'utilisateur (technicien ou admin) qui a assigné le ticket
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

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'ticket_assigned',
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject ? $this->ticket->subject : '(sans sujet)',
            'priority' => $this->ticket->priority ?? null,
            'status' => $this->ticket->status ?? null,
            'assigned_by' => $this->assignedBy?->name,
            'message' => "un ticket vous a été assigné : \"({$this->ticket->subject})\".",
        ];
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
}
