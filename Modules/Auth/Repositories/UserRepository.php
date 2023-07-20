<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Entities\User;
use Modules\Core\Repositories\BaseRepository;

/**
 * @extends BaseRepository<User>
 */
class UserRepository extends BaseRepository
{
    protected function model()
    {
        return new User();
    }
}
