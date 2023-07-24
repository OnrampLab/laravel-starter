<?php

namespace Modules\Auth\Services;

use Illuminate\Support\LazyCollection;
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
     * @return LazyCollection<int, User>
     */
    public function perform(): LazyCollection
    {
        return $this->userRepository->all();
    }
}
