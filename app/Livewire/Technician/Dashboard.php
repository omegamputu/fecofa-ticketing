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

        return view('livewire.technician.dashboard', compact(['unassigned', 'assigned', 'resolved']))->title('Dashboard Technicien');
    }
}
