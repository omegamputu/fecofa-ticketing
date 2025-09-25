<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->created_by || $user->can('admin.access');
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        // Le Demandeur peut éditer tant que le ticket est "open" et lui appartient
        return $user->id === $ticket->created_by && in_array($ticket->status, ['open']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function comment(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->created_by || $user->can('admin.access');
    }

    /**
     * Determine whether the user can create models.
     */
    public function attach(User $user, Ticket $ticket): bool
    {
        return $this->comment($user, $ticket);
    }

    public function resolve(User $user, Ticket $ticket): bool
    {
        if ($user->can('tickets.resolve') && $ticket->assigned_to === $user->id) {
            // Technicien ou Admin
            return true;
        }

        return $user->can('admin.access');
    }

}
