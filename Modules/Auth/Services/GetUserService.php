<?php

namespace Modules\Auth\Services;

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

    public function perform(int $userId)
    {
        return $this->userRepository->find($userId);
    }
}
