<?php

namespace Modules\Auth\Services;

use Exception;
use Hash;
use Illuminate\Support\Str;
use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function createUser(array $attributes)
    {
        $password = data_get($attributes, 'password', Str::random(8));
        $encryptedPassword = Hash::make($password);
        $attributes['password'] = $encryptedPassword;

        return User::create($attributes);
    }
}
