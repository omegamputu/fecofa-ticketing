<?php

namespace App\Livewire\Technician\Tickets;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

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
                'resolved_by'    => Auth::id(),
                'resolution_note'=> $note,
            ]);

            unset($this->resolutionNotes[$ticketId]);

            // force le rafraîchissement de la pagination pour voir le ticket immédiatement
            $this->resetPage(1);

            // (Option) notifier le Demandeur
            if ($ticket->requester) {
                $ticket->requester->notify(new \App\Notifications\TicketResolvedNotification($ticket));
            }
        }

        session()->flash('status', "Ticket #{$ticket->id} marqué comme résolu.");
    }

    public function render()
    {
        $q = Ticket::with(['requester','assignee'])
            ->where('assigned_to', auth()->id());

        //dd($q);

        if ($this->search) {
            $q->where(fn($qq)=>$qq
                ->where('subject','like',"%{$this->search}%")
                ->orWhere('description','like',"%{$this->search}%"));
        }

        // 👇 logique de filtre revue
        match ($this->status) {
            'open'         => $q->where('status','open'),
            'in_progress'  => $q->where('status','in_progress'),
            'resolved'     => $q->where('status','resolved'),
            'closed'       => $q->where('status','closed'),
            default        => $q->whereIn('status', ['open','in_progress','resolved', 'closed']), // all
        };

        // Trier pour mettre les non résolus en haut
        $q->orderByRaw("FIELD(status,'open','in_progress','resolved', 'closed') asc")->latest('created_at');

        $tickets = $q->paginate(15);

        return view('livewire.technician.tickets.index', compact('tickets'))->title('Mes Tickets assignés');
    }
}
