<?php

namespace Modules\Account\Tests\Unit\Entities;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

use Modules\Auth\Entities\User;
use Modules\Account\Entities\AccountApiKey;
use Modules\Account\Entities\Account;

class AccountApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->account = factory(Account::class)->create();
        $this->accountApiKey = factory(AccountApiKey::class)->create([
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
