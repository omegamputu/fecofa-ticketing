<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public User $user;
    public string $name = '', $email;
    public array $roles = [], $selectedRoles = [];
    
    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = Role::pluck('name')->toArray();
        $this->selectedRoles = $user->getRoleNames()->toArray();
    }

    public function save()
    {
        $this->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email,'.$this->user->id,
        ]);

        $this->user->update(['name'=>$this->name,'email'=>$this->email]);
        $this->user->syncRoles($this->selectedRoles);

        session()->flash('status','Utilisateur mis à jour.');
        return redirect()->route('admin.users.index');
    }
    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
