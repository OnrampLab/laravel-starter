<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\Account;
use Prettus\Repository\Eloquent\BaseRepository;

class AccountRepository extends BaseRepository
{
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return Account::class;
    }
}
