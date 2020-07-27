<?php

namespace Modules\Auth\Tests;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;
use Modules\Auth\Services\GetUserService;

class GetUserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->repositoryMock = Mockery::mock(UserRepository::class);
        $this->app->instance(UserRepository::class, $this->repositoryMock);
        $this->service = app(GetUserService::class);
    }

    /**
     * @test
     *
     */
    public function perform_should_work()
    {
        $this->repositoryMock
            ->shouldReceive('find')
            ->once()
            ->withArgs(function ($userId) {
                return $userId === $this->user->id;
            })
            ->andReturn($this->user);

        $this->service->perform($this->user->id);
    }
}
