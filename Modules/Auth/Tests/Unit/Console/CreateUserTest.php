<?php

namespace Modules\Auth\Tests\Unit\Console;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

use Modules\Account\Entities\Account;
use Modules\Auth\Entities\User;

/**
 * @group console
 */
class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'system-admin']);

        $this->account = factory(Account::class)->create();
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
            'role' => 'system-admin',
            'account' => $this->account->id,
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
            'role' => 'system-admin',
            'account' => $this->account->id,
        ];
        $this->artisan('auth:create-user', $userData)
            ->assertExitCode(0);

        $user = User::first();

        $this->assertEquals(1, User::count());
        $this->assertEquals($userData['email'], $user->email);
        $this->assertEquals($userData['name'], $user->name);
   }

}
