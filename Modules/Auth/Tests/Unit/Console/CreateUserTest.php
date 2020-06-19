<?php

namespace Modules\Auth\Tests\Unit\Console;

use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Modules\Auth\Entities\User;
use Tests\TestCase;

/**
 * @group console
 */
class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test command can be success
     *
     * @test
     *
     * @return void
     */
    public function handle_should_create_a_new_user()
    {
        $userData = [
            'email' => 'test@test.com',
            'name' => 'Test User',
            'password' => 'test',
        ];
        $this->artisan('auth:create-user', $userData)
            ->assertExitCode(0);

        $user = User::first();

        $this->assertEquals(1, User::count());
        $this->assertEquals($userData['email'], $user->email);
        $this->assertEquals($userData['name'], $user->name);
   }

   /**
     * Test command can be success
     *
     * @test
     *
     * @return void
     */
    public function handle_should_create_a_new_user_with_auto_generated_password()
    {
        $userData = [
            'email' => 'test@test.com',
            'name' => 'Test User',
        ];
        $this->artisan('auth:create-user', $userData)
            ->assertExitCode(0);

        $user = User::first();

        $this->assertEquals(1, User::count());
        $this->assertEquals($userData['email'], $user->email);
        $this->assertEquals($userData['name'], $user->name);
   }

}
