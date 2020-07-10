<?php

namespace Modules\Account\Contracts;

use Modules\Account\Entities\Account;

abstract class AccountContract {
    abstract public function getAccount(): Account;

    function getAccounts(): array {
        return [$this->getAccount()];
    }
}
