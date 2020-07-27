<?php

namespace Modules\Auth\Policies;

use Modules\Auth\Entities\User;

class UserPolicy
{
    /**
     * Determine if the given resource can be created by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasRole('system-admin');
    }

    /**
     * Determine if any resources can be viewed by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('system-admin');
    }

    /**
     * Determine if the given resource can be viewed by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasRole('system-admin');
    }

    /**
     * Determine if the given resource can be updated by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasRole('system-admin');
    }

    /**
     * Determine if the given resource can be deleted by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasRole('system-admin');
    }
}
