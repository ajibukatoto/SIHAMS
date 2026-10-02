<?php

namespace App\Policies;

use App\Models\HelpDeskTicket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HelpDeskTicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('tickets.view');
    }

    public function view(User $user, HelpDeskTicket $ticket): bool
    {
        if (! $user->can('tickets.view')) {
            return false;
        }

        return $this->canAccessTicket($user, $ticket);
    }

    public function create(User $user): bool
    {
        return $user->can('tickets.create');
    }

    public function update(User $user, HelpDeskTicket $ticket): bool
    {
        if (! $user->can('tickets.update')) {
            return false;
        }

        $roles = $this->getRoles($user);

        if (
            in_array('Super Admin', $roles, true) ||
            in_array('ICT Manager', $roles, true)
        ) {
            return true;
        }

        if (in_array('ICT Technician', $roles, true)) {
            return $ticket->assigned_to === $user->id;
        }

        if (in_array('Employee', $roles, true)) {
            return (
                $ticket->requester_id === $user->id
                && ! in_array(
                    $ticket->status,
                    ['resolved', 'closed', 'cancelled'],
                    true
                )
            );
        }

        return false;
    }

    public function delete(User $user, HelpDeskTicket $ticket): bool
    {
        if (! $user->can('tickets.delete')) {
            return false;
        }

        $roles = $this->getRoles($user);

        return (
            in_array('Super Admin', $roles, true) ||
            in_array('ICT Manager', $roles, true)
        );
    }

    public function restore(User $user, HelpDeskTicket $ticket): bool
    {
        return false;
    }

    public function forceDelete(User $user, HelpDeskTicket $ticket): bool
    {
        return false;
    }

    public function assign(User $user, HelpDeskTicket $ticket): bool
    {
        if (! $user->can('tickets.assign')) {
            return false;
        }

        $roles = $this->getRoles($user);

        return (
            in_array('Super Admin', $roles, true) ||
            in_array('ICT Manager', $roles, true)
        );
    }

    public function resolve(User $user, HelpDeskTicket $ticket): bool
    {
        if (! $user->can('tickets.resolve')) {
            return false;
        }

        $roles = $this->getRoles($user);

        if (
            in_array('Super Admin', $roles, true) ||
            in_array('ICT Manager', $roles, true)
        ) {
            return true;
        }

        return (
            in_array('ICT Technician', $roles, true)
            && $ticket->assigned_to === $user->id
        );
    }

    public function close(User $user, HelpDeskTicket $ticket): bool
    {
        if (! $user->can('tickets.close')) {
            return false;
        }

        $roles = $this->getRoles($user);

        return (
            in_array('Super Admin', $roles, true) ||
            in_array('ICT Manager', $roles, true)
        );
    }

    private function canAccessTicket(
        User $user,
        HelpDeskTicket $ticket
    ): bool {
        $roles = $this->getRoles($user);

        if (
            in_array('Super Admin', $roles, true) ||
            in_array('ICT Manager', $roles, true) ||
            in_array('Auditor', $roles, true)
        ) {
            return true;
        }

        if (in_array('ICT Technician', $roles, true)) {
            return $ticket->assigned_to === $user->id;
        }

        if (in_array('Employee', $roles, true)) {
            return $ticket->requester_id === $user->id;
        }

        return false;
    }

    private function getRoles(User $user): array
    {
        return DB::table('model_has_roles')
            ->join(
                'roles',
                'roles.id',
                '=',
                'model_has_roles.role_id'
            )
            ->where(
                'model_has_roles.model_id',
                $user->id
            )
            ->where(
                'model_has_roles.model_type',
                User::class
            )
            ->pluck('roles.name')
            ->toArray();
    }
} 
