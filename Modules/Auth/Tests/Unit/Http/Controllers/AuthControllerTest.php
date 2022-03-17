<?php
namespace Modules\Contact\Http\Controllers;

use Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Modules\Auth\Entities\User;
use Modules\Auth\Http\Resources\UserResource;

/**
 * @group api
 */
class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userData = [
            'email' => 'test@test.com',
            'password' => 'test',
        ];
        $this->user = User::factory()->create([
            'email' => $this->userData['email'],
            'password' => Hash::make($this->userData['password']),
        ]);
        $this->token = auth()->attempt($this->userData);
        $this->headers = [
            'Authorization' => "Bearer: $this->token",
        ];
    }

    /**
     * @test login()
     *
     * @return void
     */
    public function login_should_succeed()
    {
        $url = '/api/auth/login';
        $data = [
            'email'
        ];
        $response = $this->json('POST', $url, $this->userData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'access_token', 'expires_in', 'token_type'
            ],
        ]);
    }

    /**
     * @test login()
     * @dataProvider failedLoginProvider
     * @return void
     */
    public function login_should_fail_when_wrong_email_or_password($email, $password)
    {
        $url = '/api/auth/login';

        $response = $this->json('POST', $url, [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(401);
        $response->assertExactJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function failedLoginProvider()
    {
        return [
            'wrong_email'    => ['wrong@test.com', 'test'],
            'wrong_password' => ['test@test.com', '123'],
        ];
    }

    /**
     * @test me()
     *
     * @return void
     */
    public function me_should_succeed()
    {
        $url = '/api/auth/me';
        $data = [];

        $response = $this->json('POST', $url, $data, $this->headers);

        $response->assertStatus(200);
        $response->assertExactJson([
            'data' => (new UserResource($this->user))->toArray($data),
        ]);
    }

    /**
     * @test logout()
     *
     * @return void
     */
    public function logout_should_invalid_the_token()
    {
        $token = auth()->attempt($this->userData);
        $url = '/api/auth/logout';
        $data = [];

        $response = $this->json('POST', $url, $data, $this->headers);

        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => 'Successfully logged out',
        ]);

        $this->assertFailedToken($this->token);
    }

    /**
     * @test refresh()
     *
     * @return void
     */
    public function refresh_should_get_a_new_token()
    {
        $token = auth()->attempt($this->userData);
        $url = '/api/auth/refresh';
        $data = [];

        $response = $this->json('POST', $url, $data, $this->headers);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'access_token', 'expires_in', 'token_type'
            ],
        ]);
    }

    public function assertFailedToken($token)
    {
        $url = '/api/auth/me';
        $data = [];
        $headers = [
            'Authorization' => "Bearer: $token",
        ];

        $response = $this->json('POST', $url, $data, $headers);

        $response->assertStatus(401);
    }
}
