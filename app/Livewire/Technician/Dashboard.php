<?php

namespace App\Livewire\Technician;

use App\Models\Ticket;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // 
        $unassigned = Ticket::with('requester', 'assignee')
                                ->fromRequesters()->unassigned()
                                ->latest()->paginate(10, ['*'], 'unassigned_page');
        // 
        $assigned = Ticket::with('requester', 'assignee')
                                ->fromRequesters()->assigned()
                                ->latest()->paginate(10, ['*'], 'assigned_page');
        
        $resolved = Ticket::with('requester', 'assignee')
                                ->fromRequesters()->resolved()
                                ->latest()->paginate(10, ['*'], 'resolved_page');
        
        $closed = Ticket::with('requester', 'assignee')
                                ->fromRequesters()->closed()
                                ->where('assigned_to', auth()->id())
                                ->where('status', 'closed')
                                ->latest()->paginate(10, ['*'], 'closed_page');

        return view('livewire.technician.dashboard', compact(['unassigned', 'assigned', 'resolved', 'closed']))->title('Dashboard Technicien');
    }
}
