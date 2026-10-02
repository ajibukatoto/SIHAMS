<?php

namespace App\Policies;

use App\Models\TicketComment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TicketCommentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('ticket_comments.view');
    }

    public function view(
        User $user,
        TicketComment $comment
    ): bool {
        if (! $user->can('ticket_comments.view')) {
            return false;
        }

        return $this->canAccessComment(
            $user,
            $comment
        );
    }

    public function create(User $user): bool
    {
        return $user->can('ticket_comments.create');
    }

    public function update(
        User $user,
        TicketComment $comment
    ): bool {
        if (! $user->can('ticket_comments.update')) {
            return false;
        }

        return $this->canAccessComment(
            $user,
            $comment
        );
    }

    public function delete(
        User $user,
        TicketComment $comment
    ): bool {
        if (! $user->can('ticket_comments.delete')) {
            return false;
        }

        $roles = $this->getRoles($user);

        return (
            in_array('Super Admin', $roles, true) ||
            in_array('ICT Manager', $roles, true)
        );
    }

    public function restore(
        User $user,
        TicketComment $comment
    ): bool {
        return false;
    }

    public function forceDelete(
        User $user,
        TicketComment $comment
    ): bool {
        return false;
    }

    private function canAccessComment(
        User $user,
        TicketComment $comment
    ): bool {
        $ticket = $comment->ticket;

        if (! $ticket) {
            return false;
        }

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
