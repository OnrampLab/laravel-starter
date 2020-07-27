<?php

namespace Modules\Account\Policies;

use Modules\Account\Entities\Account;
use Modules\Auth\Entities\User;

class AccountPolicy
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
        return $user->hasAnyRole(['account-analyst', 'account-admin']);
    }

    /**
     * Determine if the given resource can be viewed by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @param  Account  $account
     * @return bool
     */
    public function view(User $user, Account $account)
    {
        return $this->canAccess($user, $account) && $user->hasAnyRole(['account-analyst', 'account-admin']);
    }

    /**
     * Determine if the given resource can be updated by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @param  Account  $account
     * @return bool
     */
    public function update(User $user, Account $account)
    {
        return $this->canAccess($user, $account) && $user->hasRole('account-admin');
    }

    /**
     * Determine if the given resource can be deleted by the user.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @param  Account  $account
     * @return bool
     */
    public function delete(User $user, Account $account)
    {
        return $this->canAccess($user, $account) && $user->hasRole('account-admin');
    }


    /**
     * Determine if the user can access the given account.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @param  Account  $model
     * @return bool
     */
    private function canAccess(User $user, Account $account)
    {
        return $user->accounts->contains(function(Account $userAccount) use ($account) {
            return $userAccount->id === $account->id;
        });
    }
}
