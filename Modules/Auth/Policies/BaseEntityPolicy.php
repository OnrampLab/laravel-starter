<?php

namespace Modules\Auth\Policies;

use Modules\Account\Contracts\AccountContract;
use Modules\Auth\Entities\User;

class BaseEntityPolicy
{
    /**
     * Determine if the given resource can be viewed by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @param  AccountContract  $model
     * @return bool
     */
    public function view(User $user, AccountContract $model)
    {
        return $user->can('view', $model->getAccount());
    }

    /**
     * Determine if the given resource can be updated by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @param  AccountContract  $model
     * @return bool
     */
    public function update(User $user, AccountContract $model)
    {
        return $user->can('update', $model->getAccount());
    }

    /**
     * Determine if the given resource can be deleted by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @param  AccountContract  $model
     * @return bool
     */
    public function delete(User $user, AccountContract $model)
    {
        return $user->can('delete', $model->getAccount());
    }
}
