<?php
namespace Modules\Contact\Http\Controllers;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

use Modules\Account\Entities\Account;
use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;
use Modules\Auth\Services\CreateUserService;

/**
 * @group service
 */
class CreateUserServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CreateUserService
     */
    protected $createUserService;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'role1']);

        $this->account = factory(Account::class)->create();
        $this->user = factory(User::class)->create();

        $this->userData = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'test',
            'roles' => ['role1'],
            'accounts' => [$this->account->id]
        ];

        $this->repositoryMock = Mockery::mock(UserRepository::class);
        $this->app->instance(UserRepository::class, $this->repositoryMock);
        $this->service = app(CreateUserService::class);
    }

    /**
     * @test perform()
     *
     * @return void
     */
    public function perform_should_work()
    {
        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->andReturn($this->user);

        $this->service->perform($this->userData);

        $actualUserRoles = $this->user->roles->pluck('name')->toArray();

        $this->assertEquals($this->userData['roles'], $actualUserRoles);

        $actualUserAccounts = $this->user->accounts->pluck('id')->toArray();

        $this->assertEquals($this->userData['accounts'], $actualUserAccounts);
    }
}
