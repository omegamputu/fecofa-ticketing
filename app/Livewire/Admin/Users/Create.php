<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public string $name = '', $email = '', $role = '';
    public array $roles = [];

    public function mount()
    {
        $this->roles = Role::whereNotIn('name', ['Super-Admin'])->pluck('name')->toArray();
    }

    public function save()
    {
        die($_POST);
        
        // Validate data
        $this->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'role'=>'required|in:'.implode(',',$this->roles),
        ]);

        // Creating user

        $user = User::create([
            'name'=> $this->name,
            'email'=> $this->email,
            'password'=> Hash::make(str()->random(32)), // jetable
        ]);

        $user->assignRole($this->role); // Assign role
        // Invitation
        Password::sendResetLink(['email' => $user->email]);

        session()->flash('status', 'User created successfully and invitation sent !');

         return redirect()->route('admin.users.index');
    }
    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
