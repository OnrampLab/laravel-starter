<?php

namespace Modules\Account\Policies;

use Modules\Account\Entities\Account;
use Modules\Auth\Entities\User;

class AccountPolicy
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
        return $user->hasAnyRole(['account-analyst', 'account-admin']);
    }

    /**
     * Determine if the given resource can be viewed by the user.
     */
    public function view(User $user, Account $account): bool
    {
        return $this->canAccess($user, $account) && $user->hasAnyRole(['account-analyst', 'account-admin']);
    }

    /**
     * Determine if the given resource can be updated by the user.
     */
    public function update(User $user, Account $account): bool
    {
        return $this->canAccess($user, $account) && $user->hasRole('account-admin');
    }

    /**
     * Determine if the given resource can be deleted by the user.
     */
    public function delete(User $user, Account $account): bool
    {
        return $this->canAccess($user, $account) && $user->hasRole('account-admin');
    }

    /**
     * Determine if the user can access the given account.
     */
    private function canAccess(User $user, Account $account): bool
    {
        return $user->accounts->contains('id', $account->id);
    }
}
