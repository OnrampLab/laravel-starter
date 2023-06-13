<?php

namespace Modules\Account\Listeners;

use Modules\Account\Events\AccountCreatedEvent;
use Modules\Account\Repositories\AccountApiKeyRepository;

class CreateApiKeyListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public AccountApiKeyRepository $accountApiKeyRepository)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(AccountCreatedEvent $event): void
    {
        $accountId = $event->account->id;

        $this->accountApiKeyRepository->createApiKey($accountId);
    }
}
