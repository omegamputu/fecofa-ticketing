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
            default        => $q->whereIn('status', ['open','in_progress','resolved']), // all
        };

        // Trier pour mettre les non résolus en haut
        $q->orderByRaw("FIELD(status,'open','in_progress','resolved') asc")->latest('created_at');

        $tickets = $q->paginate(15);

        return view('livewire.technician.tickets.index', compact('tickets'))->title('Mes Tickets assignés');
    }
}
