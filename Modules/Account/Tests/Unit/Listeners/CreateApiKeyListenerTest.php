<?php

namespace Modules\Account\Tests\Unit\Listeners;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Account\Entities\Account;
use Modules\Account\Repositories\AccountApiKeyRepository;
use Modules\Account\Events\AccountCreatedEvent;
use Modules\Account\Listeners\CreateApiKeyListener;

/**
 * @internal
 * @coversNothing
 */
class CreateApiKeyListenerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();

        $this->account = Account::factory()->create();
        $this->event = new AccountCreatedEvent($this->account);
        $this->accountApiKeyRepository = Mockery::mock(AccountApiKeyRepository::class);
        $this->app->instance(AccountApiKeyRepository::class, $this->accountApiKeyRepository);
        $this->listener = app(CreateApiKeyListener::class);
    }

    /**
     * Test event listener to create API key.
     *
     * @test
     */
    public function should_create_api_key()
    {
        $this->accountApiKeyRepository
            ->shouldReceive('createApiKey')
            ->once()
            ->with($this->account->id);
        $this->listener->handle($this->event);
    }
}
