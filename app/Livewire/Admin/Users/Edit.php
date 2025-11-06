<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public User $user;
    public string $name = '';
    public string $email;
    public ?string $job_title = null;
    public array $roles = [];
    public array $selectedRoles = [];
    
    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->job_title = $user->job_title;
        $this->roles = Role::pluck('name')->toArray();
        $this->selectedRoles = $user->getRoleNames()->toArray();
    }

    public function save()
    {
        $this->validate([
            'name'  =>  'required|string|max:255',
            'email' =>  'required|email|unique:users,email,'.$this->user->id,
            'job_title' =>  'nullable|string|max:255',
        ]);

        $this->user->update([
            'name'  => $this->name,
            'email' => $this->email,
            'job_title' => $this->job_title,
        ]);

        $this->user->syncRoles($this->selectedRoles);

        session()->flash('status','Utilisateur mis à jour.');

        return redirect()->route('admin.users.index');
    }

    public function resendInvitation()
    {
        $this->authorize('users.manage');

        // Renvoi via broker d’invitation
        Password::broker('invites')->sendResetLink(['email' => $this->user->email]);

        // Trace
        $this->user->invited_at = now();
        $this->user->increment('invitation_sent_count');
        $this->user->save();

        session()->flash('status','Invitation renvoyée à '.$this->user->email);
    }

    private function statusLabel(): string
    {
        if (is_null($this->user->invited_at)) {
            return 'Jamais invité';
        }
        if (is_null($this->user->last_login_at)) {
            return 'Invité (en attente)';
        }

        // grâce aux casts, c’est un Carbon ; sinon on parse par sécurité
        $last = $this->user->last_login_at instanceof \Illuminate\Support\Carbon
            ? $this->user->last_login_at
            : \Illuminate\Support\Carbon::parse($this->user->last_login_at);

        return 'Actif — dernière connexion : '.$last->format('d/m/Y H:i');
    }

    public function render()
    {
        return view('livewire.admin.users.edit', [
            'statusLabel'=> $this->statusLabel(),
        ])->title('Éditer utilisateur');
    }
}
