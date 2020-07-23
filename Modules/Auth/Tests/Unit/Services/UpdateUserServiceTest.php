<?php

namespace Modules\Auth\Tests;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

use Modules\Account\Entities\Account;
use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;
use Modules\Auth\Services\UpdateUserService;

class UpdateUserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'role1']);
        Role::create(['name' => 'role2']);

        $this->accounts = factory(Account::class, 2)->create();
        $this->user = factory(User::class)->create();
        $this->repositoryMock = Mockery::mock(UserRepository::class);
        $this->app->instance(UserRepository::class, $this->repositoryMock);
        $this->service = app(UpdateUserService::class);
    }

    /**
     * @test
     *
     */
    public function perform_should_work()
    {
        $this->user->assignRole(['role1']);
        $this->user->accounts()->attach([$this->accounts->first()->id]);

        $attributes = [
            'name' => 'test',
            'email' => 'test@test.com',
            'roles' => ['role2'],
            'accounts' => $this->accounts->pluck('id')->toArray()
        ];

        $this->repositoryMock
            ->shouldReceive('update')
            ->once()
            ->withArgs(function ($userAttributes, $userId) use ($attributes) {
                return $userAttributes === $attributes
                    && $userId === $this->user->id;
            })
            ->andReturn($this->user);

        $this->service->perform($attributes, $this->user->id);

        $actualUserRoles = $this->user->roles->pluck('name')->toArray();

        $this->assertEquals($attributes['roles'], $actualUserRoles);

        $actualUserAccounts = $this->user->accounts->pluck('id')->toArray();

        $this->assertEquals($attributes['accounts'], $actualUserAccounts);
    }
}
