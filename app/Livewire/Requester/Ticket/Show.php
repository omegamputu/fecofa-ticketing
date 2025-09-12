<?php

namespace App\Livewire\Requester\Ticket;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public Ticket $ticket;
    public string $comment = '';
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

        $c = TicketComment::create([
            'ticket_id' => $this->ticket->id,
            'commented_by' => Auth::id(),
            'comment' => $this->comment
        ]);

        if($this->attachment)
        {
            $this->authorize('attach', $this->ticket);
            $path = $this->attachment->store("tickets/{$this->ticket->id}", 'public');

            TicketAttachment::create([
                'ticket_id'     => $this->ticket->id,
                'uploaded_by'   => Auth::id(),
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
        return view('livewire.requester.ticket.show')->title($this->ticket->subject);
    }
}
