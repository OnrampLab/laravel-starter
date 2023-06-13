<?php

namespace Modules\Account\Events;

use Modules\Account\Entities\Account;

class AccountCreatedEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(public Account $account)
    {
    }
}
