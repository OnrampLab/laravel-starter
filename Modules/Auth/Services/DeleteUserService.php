<?php

namespace Modules\Auth\Services;

use Modules\Auth\Repositories\UserRepository;

class DeleteUserService
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

    public function perform(int $userId): int
    {
        return $this->userRepository->delete($userId);
    }
}
