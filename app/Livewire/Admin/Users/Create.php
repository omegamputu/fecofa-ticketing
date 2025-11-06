<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\InvitationResetPassword;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public string $name = '';
    public string $email = '';
    public ?string $job_title = null;
    public string $role = '';
    public array $roles = [];

    public function mount()
    {
        $this->roles = Role::whereNotIn('name', ['Super-Admin'])->pluck('name')->toArray();
    }

    public function save()
    {
        // Validate data
        $this->validate([
            'name'=>'required|string|max:255',
            'email' => ['required','email','max:255','unique:users,email','regex:/@fecofa\.cd$/i'],
            'job_title'=>'nullable|string|max:255',
            'role'=>'required|in:'.implode(',',$this->roles),
        ]);

        // Creating user

        $user = User::create([
            'name'=> $this->name,
            'email'=> $this->email,
            'job_title'=> $this->job_title,
            'password'=> Hash::make(str()->random(32)), // jetable
        ]);

        $user->assignRole($this->role); // Assign role
        // Invitation

        // Alternatively, you can use the sendInvite method
        $this->sendInvite($user);

        $user->forceFill([
            'invited_at' => now(),
        ])->save();

        $user->increment('invitation_sent_count');

        session()->flash('status', 'User created successfully and invitation sent !');

         return redirect()->route('admin.users.index');
    }

    public function sendInvite(User $user): void
    {
        Cache::put("invite:{$user->email}", true, now()->addMinutes(2));

        Password::broker('invites')->sendResetLink(['email' => $user->email]);
    }

    public function render()
    {
        return view('livewire.admin.users.create')->title('Add user');
    }
}
