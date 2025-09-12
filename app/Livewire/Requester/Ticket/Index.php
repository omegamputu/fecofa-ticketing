<?php

namespace App\Livewire\Requester\Ticket;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search='', $status='all', $priority='all';
    public string $category;
    public array $categories = [];


    public function render()
    {

        $q = Ticket::query()->where('created_by', Auth::id());

        if ($this->search)  $q->where(fn($qq)=>$qq
            ->where('subject','like',"%{$this->search}%")
            ->orWhere('description','like',"%{$this->search}%"));

        if ($this->status !== 'all')   $q->where('status',$this->status);
        if ($this->priority !== 'all') $q->where('priority',$this->priority);
       // if ($this->category !== 'all') $q->where('category',$this->category);

        $tickets = $q->latest()->paginate(10);

        return view('livewire.requester.ticket.index', compact('tickets'))->title('My Tickets');
    }
}
