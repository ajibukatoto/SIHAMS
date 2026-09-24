<?php

namespace App\Policies;

use App\Models\HelpDeskTicket;
use App\Models\User;

class HelpDeskTicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('tickets.view');
    }

    public function view(
        User $user,
        HelpDeskTicket $ticket
    ): bool {
        if (! $user->can('tickets.view')) {
            return false;
        }

        return $this->canAccessTicket($user, $ticket);
    }

    public function create(User $user): bool
    {
        return $user->can('tickets.create');
    }

    public function update(
        User $user,
        HelpDeskTicket $ticket
    ): bool {
        if (! $user->can('tickets.update')) {
            return false;
        }

        return $this->canAccessTicket($user, $ticket);
    }

    public function delete(
        User $user,
        HelpDeskTicket $ticket
    ): bool {
        if (! $user->can('tickets.delete')) {
            return false;
        }

        if (
            $user->hasRole('Super Admin') ||
            $user->hasRole('ICT Manager')
        ) {
            return true;
        }

        return false;
    }

    public function restore(
        User $user,
        HelpDeskTicket $ticket
    ): bool {
        return false;
    }

    public function forceDelete(
        User $user,
        HelpDeskTicket $ticket
    ): bool {
        return false;
    }

    private function canAccessTicket(
        User $user,
        HelpDeskTicket $ticket
    ): bool {
        if (
            $user->hasRole('Super Admin') ||
            $user->hasRole('ICT Manager') ||
            $user->hasRole('Auditor')
        ) {
            return true;
        }

        if ($user->hasRole('ICT Technician')) {
            return $ticket->assigned_to === $user->id;
        }

        if ($user->hasRole('Employee')) {
            return $ticket->requester_id === $user->id;
        }

        return false;
    }
}
