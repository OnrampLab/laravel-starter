<?php

namespace Modules\Account\Tests\Unit\Entities;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Account\Entities\AccountApiKey;
use Modules\Account\Entities\Account;
use Tests\EntityTestCase;

/**
 * @internal
 * @coversNothing
 */
class AccountApiTest extends EntityTestCase
{
    protected function model(): string
    {
        return AccountApiKey::class;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->account = Account::factory()->create();
        $this->accountApiKey = AccountApiKey::factory()->create([
            'account_id' => $this->account->id,
        ]);
    }

    public function test_properties()
    {
        $this->assertNotNull($this->accountApiKey->account_id);
        $this->assertNotNull($this->accountApiKey->token);
    }

    public function test_relations()
    {
        $this->assertEquals($this->accountApiKey->account->id, $this->accountApiKey->account_id);
    }
}
