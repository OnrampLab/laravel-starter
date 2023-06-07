<?php

namespace Modules\Account\Tests\Unit\Entities;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Entities\User;
use Modules\Account\Entities\Account;

/**
 * @internal
 * @coversNothing
 */
class AccountTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->account = Account::factory()->create();
        $this->account->users()->attach($this->user->id);
    }

    public function test_properties()
    {
        $this->assertNotNull($this->account->name);
    }

    public function test_relations()
    {
        $this->assertEquals($this->account->users->count(), 1);
    }
}
