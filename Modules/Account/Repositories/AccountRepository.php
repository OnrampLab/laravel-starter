<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\Account;
use Modules\Core\Repositories\BaseRepository;

/**
 * @extends BaseRepository<Account>
 */
class AccountRepository extends BaseRepository
{
    public function model()
    {
        return new Account();
    }
}
