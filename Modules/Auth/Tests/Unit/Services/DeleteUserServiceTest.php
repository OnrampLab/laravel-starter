<?php

namespace Modules\Auth\Tests;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;
use Modules\Auth\Services\DeleteUserService;

/**
 * @internal
 * @coversNothing
 */
class DeleteUserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->repositoryMock = Mockery::mock(UserRepository::class);
        $this->app->instance(UserRepository::class, $this->repositoryMock);
        $this->service = app(DeleteUserService::class);
    }

    /**
     * @test
     */
    public function perform_should_work()
    {
        $this->repositoryMock
            ->shouldReceive('delete')
            ->once()
            ->withArgs(function ($userId) {
                return $userId === $this->user->id;
            })
            ->andReturn(true);

        $this->service->perform($this->user->id);
    }
}
