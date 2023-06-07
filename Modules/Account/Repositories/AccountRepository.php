<?php

namespace Modules\Account\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Account\Entities\Account;

class AccountRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Account::class;
    }
}
