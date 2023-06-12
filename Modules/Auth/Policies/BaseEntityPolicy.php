<?php

namespace Modules\Auth\Policies;

use Modules\Account\Contracts\AccountContract;
use Modules\Account\Entities\Account;
use Modules\Auth\Entities\User;

class BaseEntityPolicy
{
    /**
     * Determine if the resource can be created by the user.
     */
    public function create(User $user, Account $account): bool
    {
        return $this->canAccess($user, $account) && $user->hasRole('account-admin');
    }

    /**
     * Determine if any resources can be viewed by the user.
     */
    public function viewAny(User $user, Account $account): bool
    {
        return $this->canAccess($user, $account) && $user->hasAnyRole(['account-analyst', 'account-admin']);
    }

    /**
     * Determine if the given resource can be viewed by the user.
     */
    public function view(User $user, AccountContract $model): bool
    {
        return $this->canAccess($user, $model->getAccount()) && $user->hasAnyRole(['account-analyst', 'account-admin']);
    }

    /**
     * Determine if the given resource can be updated by the user.
     */
    public function update(User $user, AccountContract $model): bool
    {
        return $this->canAccess($user, $model->getAccount()) && $user->hasRole('account-admin');
    }

    /**
     * Determine if the given resource can be deleted by the user.
     */
    public function delete(User $user, AccountContract $model): bool
    {
        return $this->canAccess($user, $model->getAccount()) && $user->hasRole('account-admin');
    }

    /**
     * Determine if the user can access the given account.
     */
    private function canAccess(User $user, Account $account): bool
    {
        return $user->accounts->contains(function (Account $userAccount) use ($account) {
            return $userAccount->id === $account->id;
        });
    }
}
