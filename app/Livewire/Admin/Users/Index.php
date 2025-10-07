<?php

namespace App\Livewire\Admin\Users;

use App\Models\Category;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Définir l'attribut search
    public string $search = '';

    public function render()
    {
        // Faire une recherche en se basant sur les noms
        $users = User::with('roles')->when($this->search, fn($q)=>$q->where(function ($q){
            $q->where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%");
        }))
        ->latest()->paginate(10);

        return view('livewire.admin.users.index', compact('users'))->title('Liste des utilisateurs');
    }

    public function delete(int $id)
    {

        abort_unless(auth()->user()->can('users.manage'), 403);
        User::findOrFail($id)->delete();
        session()->flash('status', 'User deleted successfully.');
    }
    
}
