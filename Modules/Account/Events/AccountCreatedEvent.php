<?php

namespace Modules\Account\Events;

use Modules\Account\Entities\Account;

class AccountCreatedEvent
{
    public $account;

    /**
     * Create a new event instance.
     *
     * @param Account $account
     * @return void
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }
}
