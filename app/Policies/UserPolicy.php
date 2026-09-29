<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'users.view');
    }

    public function view(User $user, User $record): bool
    {
        return $this->hasPermission($user, 'users.view');
    }

    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    public function update(User $user, User $record): bool
    {
        return $this->isSuperAdmin($user);
    }

    public function delete(User $user, User $record): bool
    {
        if (! $this->isSuperAdmin($user)) {
            return false;
        }

        return $user->id !== $record->id;
    }

    public function restore(User $user, User $record): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $record): bool
    {
        return false;
    }

    private function isSuperAdmin(User $user): bool
    {
        return DB::table('model_has_roles')
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
            ->where('roles.name', 'Super Admin')
            ->exists();
    }

    private function hasPermission(
        User $user,
        string $permission
    ): bool {
        return DB::table('model_has_permissions')
            ->join(
                'permissions',
                'permissions.id',
                '=',
                'model_has_permissions.permission_id'
            )
            ->where(
                'model_has_permissions.model_id',
                $user->id
            )
            ->where(
                'model_has_permissions.model_type',
                User::class
            )
            ->where('permissions.name', $permission)
            ->exists();
    }
}
