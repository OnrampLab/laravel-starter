<?php

namespace Modules\Account\Tests\Unit\Entities;

use Modules\Auth\Entities\User;
use Modules\Account\Entities\Account;
use Tests\EntityTestCase;

/**
 * @internal
 * @coversNothing
 */
class AccountTest extends EntityTestCase
{
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

    protected function model(): string
    {
        return User::class;
    }
}
