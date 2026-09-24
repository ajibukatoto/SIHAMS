<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HelpDeskTicket extends Model
{
    protected $fillable = [
        'ticket_number',
        'requester_id',
        'department_id',
        'office_id',
        'assigned_to',
        'category',
        'priority',
        'status',
        'subject',
        'description',
        'resolution',
        'opened_at',
        'assigned_at',
        'resolved_at',
        'closed_at',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'assigned_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'requester_id'
        );
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            Department::class
        );
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(
            Office::class
        );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(
            TicketComment::class
        );
    }

    public function scopeVisibleTo(
        Builder $query,
        ?User $user = null
    ): Builder {
        $user = $user ?? Auth::user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        /*
         * Get the roles assigned to the authenticated user
         * directly from Spatie's role tables.
         */
        $roles = DB::table('model_has_roles')
            ->join(
                'roles',
                'roles.id',
                '=',
                'model_has_roles.role_id'
            )
            ->where('model_has_roles.model_id', $user->id)
            ->where(
                'model_has_roles.model_type',
                User::class
            )
            ->pluck('roles.name')
            ->toArray();

        /*
         * Super Admin, ICT Manager and Auditor
         * can see all tickets.
         */
        if (
            in_array('Super Admin', $roles, true) ||
            in_array('ICT Manager', $roles, true) ||
            in_array('Auditor', $roles, true)
        ) {
            return $query;
        }

        /*
         * ICT Technician can only see tickets
         * assigned to them.
         */
        if (
            in_array('ICT Technician', $roles, true)
        ) {
            return $query->where(
                'assigned_to',
                $user->id
            );
        }

        /*
         * Employee can only see tickets
         * requested by themselves.
         */
        if (
            in_array('Employee', $roles, true)
        ) {
            return $query->where(
                'requester_id',
                $user->id
            );
        }

        /*
         * Users without a recognized role
         * should not see any tickets.
         */
        return $query->whereRaw('1 = 0');
    }
}
