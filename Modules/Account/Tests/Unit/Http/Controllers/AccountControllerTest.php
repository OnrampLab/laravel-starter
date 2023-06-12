<?php

namespace Modules\Account\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Modules\Account\Entities\Account;
use Modules\Account\Events\AccountCreatedEvent;

/**
 * @internal
 * @coversNothing
 */
class AccountControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();

        $this->account = Account::factory()->create();
    }

    /**
     * @test
     */
    public function index()
    {
        $url = '/api/accounts';
        $response = $this->json('GET', $url);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonStructure([
            '*' => [
                '*' => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function store()
    {
        $url = '/api/accounts';
        $payload = [
            'name' => 'new name',
        ];

        $response = $this->json('POST', $url, $payload);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => $payload['name'],
        ]);
    }

    /**
     * @test
     */
    public function store_should_emit_account_created_event()
    {
        $url = '/api/accounts';
        $payload = [
            'name' => 'new name',
        ];

        $response = $this->json('POST', $url, $payload);

        Event::assertDispatched(AccountCreatedEvent::class);
    }

    /**
     * @test
     */
    public function update()
    {
        $accountId = $this->account->id;
        $url = "/api/accounts/{$accountId}";
        $payload = [
            'name' => 'new name',
        ];

        $response = $this->json('PATCH', $url, $payload);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $payload['name'],
        ]);
    }

    /**
     * test destroy() with id.
     *
     * @test
     */
    public function destroy()
    {
        $accountId = $this->account->id;
        $url = "/api/accounts/{$accountId}";
        $response = $this->json('DELETE', $url);

        $account = $this->account->find($accountId);
        $this->assertNull($account);
        $response->assertStatus(204);
    }
}
