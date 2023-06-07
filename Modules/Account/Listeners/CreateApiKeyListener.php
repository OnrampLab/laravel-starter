<?php

namespace Modules\Account\Listeners;

use Modules\Account\Repositories\AccountApiKeyRepository;
use Modules\Account\Events\AccountCreatedEvent;

class CreateApiKeyListener
{
    public $accountApiKeyRepository;

    /**
     * Create the event listener.
     */
    public function __construct(AccountApiKeyRepository $accountApiKeyRepository)
    {
        $this->accountApiKeyRepository = $accountApiKeyRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle(AccountCreatedEvent $event)
    {
        $accountId = $event->account->id;

        $this->accountApiKeyRepository->createApiKey($accountId);
    }
}
