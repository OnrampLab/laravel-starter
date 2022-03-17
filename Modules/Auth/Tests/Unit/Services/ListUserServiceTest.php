<?php

namespace Modules\Auth\Tests;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;
use Modules\Auth\Services\ListUserService;

class ListUserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->repositoryMock = Mockery::mock(UserRepository::class);
        $this->app->instance(UserRepository::class, $this->repositoryMock);
        $this->service = app(ListUserService::class);
    }

    /**
     * @test
     *
     */
    public function perform_should_work()
    {
        $this->repositoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn(collect([$this->user]));

        $this->service->perform();
    }
}
