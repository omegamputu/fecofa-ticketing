<?php

namespace App\Livewire\Technician\Tickets;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use Livewire\Component;

class Show extends Component
{
    public Ticket $ticket;
    public $comment = '';
    public $attachment; 

    public function mount(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $this->ticket = $ticket->load(['comments.commenter', 'attachments']);
    }

    public function addComment()
    {
        $this->authorize('comment', $this->ticket);
        $this->validate(['comment' => ['required', 'string', 'min:2']]);

        $this->ticket->comments()->create([
            'commented_by' => auth()->id(),
            'comment' => $this->comment
        ]);

        if($this->attachment)
        {
            $this->authorize('attach', $this->ticket);
            $path = $this->attachment->store("tickets/{$this->ticket->id}", 'public');

            TicketAttachment::create([
                'ticket_id'     => $this->ticket->id,
                'uploaded_by'   => auth()->id(),
                'file_path'     => $path,
                'file_name'     => $this->attachment->getClientOriginalName(),
                'size'          => $this->attachment->getSize(),
            ]);
        }
        $this->reset(['comment', 'attachment']);
        $this->ticket->refresh()->load(['comments.commenter', 'attachments']);
    }

    public function render()
    {
        return view('livewire.technician.tickets.show')->title($this->ticket->subject);
    }
}
