<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return User::class;
    }
}
