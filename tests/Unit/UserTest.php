<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     *
     * @return void
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
