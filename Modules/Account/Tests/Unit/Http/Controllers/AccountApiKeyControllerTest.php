<?php
namespace Modules\Account\Tests\Unit\Http\Controllers;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

use Modules\Account\Entities\Account;
use Modules\Account\Entities\AccountApiKey;

class AccountApiKeyControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->account = Account::factory()->create();
        $this->accountApiKey = AccountApiKey::factory()->create([
            'account_id' => $this->account->id,
        ]);
    }

    /**
     * test index() with id.
     *
     * @test
     * @return void
     */
    public function index()
    {
        $accountId = $this->account->id;
        $url = "/api/accounts/$accountId/account-api-keys";
        $response = $this->json('GET', $url);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'account_id',
                    'token',
                ],
            ],
        ]);
    }

    /**
     * test store()
     *
     * @test
     * @return void
     */
    public function store () {
        $accountId = $this->account->id;
        $url = "/api/accounts/$accountId/account-api-keys";
        $response = $this->json('POST', $url);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'account_id' => $accountId,
        ]);
    }

    /**
     * test destroy() with id.
     *
     * @test
     * @return void
     */
    public function destroy () {
        $accountId = $this->account->id;
        $accountApiKeyId = $this->accountApiKey->id;
        $url = "/api/accounts/$accountId/account-api-keys/$accountApiKeyId";
        $response = $this->json('DELETE', $url);

        $accountApiKey = $this->accountApiKey->find($accountApiKeyId);
        $this->assertNull($accountApiKey);
        $response->assertStatus(204);
    }
}
