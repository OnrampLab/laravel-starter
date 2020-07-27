<?php

namespace Modules\Auth\Policies;

use Modules\Account\Contracts\AccountContract;
use Modules\Account\Entities\Account;
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
        return $this->canAccess($user, $model->getAccount()) && $user->hasAnyRole(['account-analyst', 'account-admin']);
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
        return $this->canAccess($user, $model->getAccount()) && $user->hasRole('account-admin');
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
        return $this->canAccess($user, $model->getAccount()) && $user->hasRole('account-admin');
    }

    /**
     * Determine if the user can access the given account.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @param  Account  $account
     * @return bool
     */
    private function canAccess(User $user, Account $account)
    {
        return $user->accounts->contains(function(Account $userAccount) use ($account) {
            return $userAccount->id === $account->id;
        });
    }
}
