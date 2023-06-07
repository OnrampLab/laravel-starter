<?php

namespace Modules\Auth\Services;

use Hash;
use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;

class UpdateUserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function perform(array $attributes, int $userId)
    {
        $user = $this->updateUser($attributes, $userId);

        $this->updateUserRoles($user, $attributes['roles']);
        $this->updateUserAccounts($user, $attributes['accounts']);

        return $user;
    }

    private function updateUser(array $attributes, int $userId): User
    {
        $password = data_get($attributes, 'password');

        if (empty($password)) {
            unset($attributes['password']);
        } else {
            $encryptedPassword = Hash::make($password);
            $attributes['password'] = $encryptedPassword;
        }

        return $this->userRepository->update($attributes, $userId);
    }

    private function updateUserRoles(User $user, array $roles): void
    {
        $user->syncRoles($roles);
    }

    private function updateUserAccounts(User $user, array $accounts): void
    {
        $user->accounts()->sync($accounts);
    }
}
