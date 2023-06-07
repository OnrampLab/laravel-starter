<?php

namespace Modules\Auth\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Auth\Entities\User;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}
