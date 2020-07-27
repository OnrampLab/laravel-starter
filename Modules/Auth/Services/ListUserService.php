<?php

namespace Modules\Auth\Services;

use Modules\Auth\Repositories\UserRepository;

class ListUserService
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

    public function perform()
    {
        $users = $this->userRepository->all();

        return $users;
    }
}
