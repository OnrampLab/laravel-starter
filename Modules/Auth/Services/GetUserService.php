<?php

namespace Modules\Auth\Services;

use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;

class GetUserService
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

    public function perform(int $userId): User
    {
        return $this->userRepository->find($userId);
    }
}
