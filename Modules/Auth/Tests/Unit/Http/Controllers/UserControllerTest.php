<?php

namespace Modules\Auth\Tests;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Modules\Auth\Entities\User;
use Modules\Auth\Services\CreateUserService;

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

    private function getAuthedRequest()
    {
        return $this
            ->withHeaders([
                'Authorization' => "Bearer $this->apiToken",
            ]);
    }
}
