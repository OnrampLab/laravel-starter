<?php

namespace Modules\Auth\Services;

use Hash;
use Illuminate\Support\Str;

use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;

class CreateUserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function perform(array $attributes)
    {
        $user = $this->createUser($attributes);

        $this->assignUserRoles($user, $attributes['roles']);
        $this->assignUserAccounts($user, $attributes['accounts']);

        return $user;
    }

    private function createUser(array $attributes): User
    {
        $password = data_get($attributes, 'password', Str::random(8));
        $encryptedPassword = Hash::make($password);
        $attributes['password'] = $encryptedPassword;

        return $this->userRepository->create($attributes);
    }

    private function assignUserRoles(User $user, array $roles): void
    {
        $user->assignRole($roles);
    }

    private function assignUserAccounts(User $user, array $accounts): void
    {
        $user->accounts()->attach($accounts);
    }
}
