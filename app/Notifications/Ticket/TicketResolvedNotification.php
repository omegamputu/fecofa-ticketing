<?php

namespace App\Notifications\Ticket;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketResolvedNotification extends Notification
{
    use Queueable;

    public Ticket $ticket;
    public $technician;

    /**
     * Create a new notification instance.
     */
    public function __construct($ticket, $technician)
    {
        //
        $this->ticket = $ticket;
        $this->technician = $technician; // l'utilisateur (technicien) qui a résolu le ticket
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
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'ticket_resolved',
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject ?? '(sans sujet)',
            'priority' => $this->ticket->priority ?? null,
            'status' => $this->ticket->status ?? 'resolved',
            'technician' => $this->technician?->name,
            'message' => "le ticket \"{$this->ticket->subject}\" a été marqué comme résolu par {$this->technician?->name}.",
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
