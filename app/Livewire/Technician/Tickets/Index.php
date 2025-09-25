<?php

namespace App\Livewire\Technician\Tickets;

use App\Models\Ticket;
use Livewire\Component;

class Index extends Component
{
    public string $status = "assigned"; // assigned|in_progress|resolved|all
    public string $search = "";
    public array $resolutionNotes = []; // [ticketId => note]

    public function start(int $ticketId): void 
    {
        $ticket = Ticket::findOrFail($ticketId);

        $this->authorize('resolve', $ticket);

        if ($ticket->status === 'open')
        {
            $ticket->update(['status' => 'in_progress']);
        }
    }

    public function resolve(int $ticketId): void 
    {
        $ticket = Ticket::with('requester')->findOrFail($ticketId);

        $this->authorize('resolve', $ticket);

        $note = $this->resolutionNotes[$ticketId] ?? null;

        $this->validate([
            "resolutionNotes.$ticketId" => ['nullable','string','min:3'],
        ]);

        if ($ticket->status !== 'resolved')
        {
            $ticket->update([
                'status'         => 'resolved',
                'resolved_at'    => now(),
                'resolved_by'    => auth()->id(),
                'resolution_note'=> $note,
            ]);

            unset($this->resolutionNotes[$ticketId]);
        }

        session()->flash('status', "Ticket #{$ticket->id} marqué comme résolu.");
    }

    public function render()
    {
        $q = Ticket::with(['requester','assignee'])
            ->where('assigned_to', auth()->id());

        if ($this->search) {
            $q->where(fn($qq)=>$qq
                ->where('subject','like',"%{$this->search}%")
                ->orWhere('description','like',"%{$this->search}%"));
        }

        if ($this->status !== 'all') {
            if ($this->status === 'assigned') {
                $q->whereIn('status', ['open','in_progress']);
            } else {
                $q->where('status', $this->status);
            }
        }

        $tickets = $q->latest()->paginate(15);

        return view('livewire.technician.tickets.index', compact('tickets'))->title('Mes Tickets assignés');
    }
}
