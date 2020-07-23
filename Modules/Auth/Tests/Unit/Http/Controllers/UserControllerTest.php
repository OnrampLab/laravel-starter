<?php

namespace Modules\Auth\Tests;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Modules\Auth\Entities\User;
use Modules\Auth\Services\CreateUserService;
use Modules\Auth\Services\ListUserService;
use Modules\Auth\Services\GetUserService;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->apiToken = auth()->login($this->user);

        $this->createUserServiceMock = Mockery::mock(CreateUserService::class);
        $this->app->instance(CreateUserService::class, $this->createUserServiceMock);

        $this->listUserServiceMock = Mockery::mock(ListUserService::class);
        $this->app->instance(ListUserService::class, $this->listUserServiceMock);

        $this->getUserServiceMock = Mockery::mock(GetUserService::class);
        $this->app->instance(GetUserService::class, $this->getUserServiceMock);
    }

    /**
     * @test
     *
     */
    public function store()
    {
        $url = '/api/users';
        $payload = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'test',
            'roles' => ['role1'],
            'accounts' => [1]
        ];

        $this->createUserServiceMock
            ->shouldReceive('perform')
            ->once()
            ->andReturn($this->user);

        $response = $this->getAuthedRequest()->json('POST', $url, $payload);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'roles',
                'accounts',
            ],
        ]);
    }

    /**
     * @test
     *
     */
    public function index()
    {
        $url = '/api/users';

        $this->listUserServiceMock
            ->shouldReceive('perform')
            ->once()
            ->andReturn(collect([$this->user]));

        $response = $this->getAuthedRequest()->json('GET', $url);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'roles',
                    'accounts',
                ],
            ],
        ]);
    }

    /**
     * @test
     *
     */
    public function show()
    {
        $url = "/api/users/{$this->user->id}";

        $this->getUserServiceMock
            ->shouldReceive('perform')
            ->once()
            ->withArgs(function ($userId) {
                return $userId === $this->user->id;
            })
            ->andReturn($this->user);

        $response = $this->getAuthedRequest()->json('GET', $url);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'roles',
                'accounts',
            ],
        ]);
    }

    private function getAuthedRequest()
    {
        return $this
            ->withHeaders([
                'Authorization' => "Bearer $this->apiToken",
            ]);
    }
}
