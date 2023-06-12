<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Collection;
use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;

class ListUserService
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

    /**
     * @return Collection<int, User>
     */
    public function perform(): Collection
    {
        return $this->userRepository->all();
    }
}
