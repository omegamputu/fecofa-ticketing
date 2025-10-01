<?php

namespace App\Livewire\Admin\Tickets;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    /** @var array<int,string>  Liste des techniciens [id => name] */
    public array $techs = [];

    /** @var array<int,int>  Sélection par ticket: [ticketId => assigneeId] */
    public array $assignees = [];

    public string $status = 'all';
    public string $search = '';


    public function mount() 
    {
        // 
        $this->techs = User::role('Technicien')->orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function assign(int $ticketId): void 
    {

        // 1) lecture sélection
        $assigneeId = $this->assignees[$ticketId] ?? null;

        // 2) validation ciblée
        $this->validate([
            "assignees.$ticketId" => ['required','integer','exists:users,id'],
        ]);

        // 3) fetch ticket
        $ticket = Ticket::with('requester')->findOrFail($ticketId);

        // 4) sécurité (si tu soupçonnes un 403, commente temporairement la ligne suivante pour tester)
        abort_unless(optional($ticket->requester)->hasRole('Demandeur'), 403);

        // 5) update
        $ticket->update([
            'assigned_to' => $assigneeId,
            'status'      => $ticket->status === 'open' ? 'in_progress' : $ticket->status,
        ]);

        unset($this->assignees[$ticketId]);

        session()->flash('status', "Technicien #{$ticket->id} assigné avec succès.");

    }

    public function closed(int $ticketId): void 
    {
        $ticket = Ticket::with('requester')->findOrFail($ticketId);

        // sécurité (si tu soupçonnes un 403, commente temporairement la ligne suivante pour tester)
        abort_unless(optional($ticket->requester)->hasRole('Demandeur'), 403);

        $ticket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        session()->flash('status', "Ticket #{$ticket->id} fermé avec succès.");
    }

    public function render()
    {
        // Base query
        $q = Ticket::with(['requester','assignee'])
            ->whereHas('requester', fn($q)=>$q->role('Demandeur'));

        // Filtres
        if ($this->search) {
            $q->where(fn($qq)=>$qq->where('subject','like',"%{$this->search}%")
                                  ->orWhere('description','like',"%{$this->search}%"));
        }

        if ($this->status!=='all') $q->where('status',$this->status);

        // Pagination
        $tickets = $q->latest()->paginate(15);

        return view('livewire.admin.tickets.index', compact('tickets'))->title('Tickets du Demandeur');
    }
}
