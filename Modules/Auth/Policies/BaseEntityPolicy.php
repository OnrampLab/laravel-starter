<?php

namespace Modules\Auth\Policies;

use Modules\Account\Contracts\AccountContract;
use Modules\Account\Entities\Account;
use Modules\Auth\Entities\User;

class BaseEntityPolicy
{
    /**
     * Determine if the resource can be created by the user.
     *
     * @return bool
     */
    public function create(User $user, Account $account)
    {
        return $this->canAccess($user, $account) && $user->hasRole('account-admin');
    }

    /**
     * Determine if any resources can be viewed by the user.
     *
     * @return bool
     */
    public function viewAny(User $user, Account $account)
    {
        return $this->canAccess($user, $account) && $user->hasAnyRole(['account-analyst', 'account-admin']);
    }

    /**
     * Determine if the given resource can be viewed by the user.
     *
     * @return bool
     */
    public function view(User $user, AccountContract $model)
    {
        return $this->canAccess($user, $model->getAccount()) && $user->hasAnyRole(['account-analyst', 'account-admin']);
    }

    /**
     * Determine if the given resource can be updated by the user.
     *
     * @return bool
     */
    public function update(User $user, AccountContract $model)
    {
        return $this->canAccess($user, $model->getAccount()) && $user->hasRole('account-admin');
    }

    /**
     * Determine if the given resource can be deleted by the user.
     *
     * @return bool
     */
    public function delete(User $user, AccountContract $model)
    {
        return $this->canAccess($user, $model->getAccount()) && $user->hasRole('account-admin');
    }

    /**
     * Determine if the user can access the given account.
     *
     * @return bool
     */
    private function canAccess(User $user, Account $account)
    {
        return $user->accounts->contains(function(Account $userAccount) use ($account) {
            return $userAccount->id === $account->id;
        });
    }
}
