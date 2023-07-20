<?php

namespace Modules\Auth\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\LazyCollection;
use Mockery;
use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;
use Modules\Auth\Services\ListUserService;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
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
     */
    public function perform_should_work()
    {
        $this->repositoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn(LazyCollection::make([$this->user]));

        $this->service->perform();
    }
}
