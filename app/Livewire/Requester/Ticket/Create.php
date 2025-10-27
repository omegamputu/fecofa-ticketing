<?php

namespace App\Livewire\Requester\Ticket;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use App\Notifications\Ticket\TicketCreatedNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public string $subject='', $description='', $priority='';
    public int $category_id;
    public array $files = [];

    public function save()
    {
        // Validation
        $this->validate([
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required','in:low,normal,high,urgent'],
            'category_id' => ['required','exists:categories,id'],
            'files.*' => ['file', 'max:5120'], // max 5MB per file
        ]);

        // Create the ticket

        $ticket = Ticket::create([
            'subject' => $this->subject,
            'description' => $this->description,
            'status' => 'open',
            'priority' => $this->priority,
            'category_id' => $this->category_id,
            'created_by' => Auth::id(),
        ]);

        // Handle file uploads

        if (!empty($this->files))
        {
            foreach ($this->files as $f) {
                $path = $f->store("tickets/{$ticket->id}", 'public');

                TicketAttachment::create([
                    'ticket_id'     => $ticket->id,
                    'uploaded_by'   => Auth::id(),
                    'file_path'     => $path,
                    'file_name' => $f->getClientOriginalName(),
                    'size'          => $f->getSize(),
                ]);
            }
        }

        $admins = User::role(['Super-Admin', 'Admin'])->get();

        foreach ($admins as $admin) {
            $admin->notify(new TicketCreatedNotification($ticket, auth()->user()));
        }

        // Flash message & redirect
        
        session()->flash('status', 'Ticket created successfully.');

        return redirect()->route('tickets.show', $ticket);
    }

    public function render()
    {
        $categories = Category::select('id', 'name')->get();

        return view('livewire.requester.ticket.create', compact('categories'))->title('Create Ticket');
    }
}
