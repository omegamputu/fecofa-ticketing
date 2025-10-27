<?php

namespace App\Livewire\Technician\Tickets;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use App\Notifications\Ticket\TicketResolvedNotification;
use Livewire\Component;

class Show extends Component
{
    public Ticket $ticket;
    public $comment = '';
    public $attachment; 

    public array $resolutionNotes = []; // [ticketId => note]

    public bool $showCommentForm = false;

    public function mount(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $this->ticket = $ticket->load(['comments.commenter', 'attachments']);
    }

    public function toggleCommentForm(): void
    {
        $this->showCommentForm = !$this->showCommentForm;
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

    public function resolve(int $ticketId): void 
    {
        $ticket = Ticket::with('requester')->findOrFail($ticketId);

        $this->authorize('resolve', $this->ticket);

        $note = $this->resolutionNotes[$ticketId] ?? null;

        $this->validate([
            "resolutionNotes.$ticketId" => ['nullable','string','min:3'],
        ]);

        if ($this->ticket->status !== 'resolved')
        {
            $this->ticket->update([
                'status'         => 'resolved',
                'resolved_at'    => now(),
                'resolved_by'    => auth()->id(),
                'resolution_note'=> $note,
            ]);

            unset($this->resolutionNotes[$ticketId]);

            $admins = User::role(['Super-Admin', 'Admin'])->get();

            foreach ($admins as $admin) {
                $admin->notify(
                    new TicketResolvedNotification($ticket, auth()->user())
                );
            }
        }

        session()->flash('status', "Ticket #{$ticket->id} marqué comme résolu.");
    }

    public function render()
    {
        return view('livewire.technician.tickets.show')->title($this->ticket->subject);
    }
}
