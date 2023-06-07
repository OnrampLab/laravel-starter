<?php

namespace Modules\Auth\Tests\Entities;

use Tests\TestCase;
use Modules\Auth\Entities\User;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->make();
    }

    /**
     * @test
     */
    public function properties()
    {
        $this->assertNotNull($this->user->name);
        $this->assertNotNull($this->user->email);
        $this->assertNotNull($this->user->email_verified_at);
        $this->assertNotNull($this->user->password);
        $this->assertNotNull($this->user->remember_token);
    }
}
