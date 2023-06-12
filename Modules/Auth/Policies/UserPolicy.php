<?php

namespace Modules\Auth\Policies;

use Modules\Auth\Entities\User;

class UserPolicy
{
    /**
     * Determine if the given resource can be created by the user.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('system-admin');
    }

    /**
     * Determine if any resources can be viewed by the user.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('system-admin');
    }

    /**
     * Determine if the given resource can be viewed by the user.
     */
    public function view(User $user): bool
    {
        return $user->hasRole('system-admin');
    }

    /**
     * Determine if the given resource can be updated by the user.
     */
    public function update(User $user): bool
    {
        return $user->hasRole('system-admin');
    }

    /**
     * Determine if the given resource can be deleted by the user.
     */
    public function delete(User $user): bool
    {
        return $user->hasRole('system-admin');
    }
}
