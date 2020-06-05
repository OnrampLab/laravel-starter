<?php
namespace Modules\Contact\Http\Controllers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Entities\User;
use Modules\Auth\Services\UserService;
use Tests\TestCase;

/**
 * @group service
 */
class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var UserService
     */
    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userData = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'test',
        ];
        $this->userService = app(UserService::class);
    }

    /**
     * @test createUser()
     *
     * @return void
     */
    public function createUser_should_succeed()
    {
        $user = $this->userService->createUser($this->userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->id);
    }
}
