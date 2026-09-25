<?php

namespace App\Policies;

use App\Models\TicketComment;
use App\Models\User;

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

        return $this->canAccessComment($user, $comment);
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

        return $this->canAccessComment($user, $comment);
    }

    public function delete(
        User $user,
        TicketComment $comment
    ): bool {
        if (! $user->can('ticket_comments.delete')) {
            return false;
        }

        return $user->hasRole('Super Admin')
            || $user->hasRole('ICT Manager');
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
