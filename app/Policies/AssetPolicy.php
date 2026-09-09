<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\User;

class AssetPolicy
{
    /**
     * Determine whether the user can view any assets.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('assets.view');
    }

    /**
     * Determine whether the user can view an asset.
     */
    public function view(User $user, Asset $asset): bool
    {
        return $user->can('assets.view');
    }

    /**
     * Determine whether the user can create assets.
     */
    public function create(User $user): bool
    {
        return $user->can('assets.create');
    }

    /**
     * Determine whether the user can update an asset.
     */
    public function update(User $user, Asset $asset): bool
    {
        return $user->can('assets.update');
    }

    /**
     * Determine whether the user can delete an asset.
     */
    public function delete(User $user, Asset $asset): bool
    {
        return $user->can('assets.delete');
    }

    /**
     * Determine whether the user can restore an asset.
     */
    public function restore(User $user, Asset $asset): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete an asset.
     */
    public function forceDelete(User $user, Asset $asset): bool
    {
        return false;
    }
}
