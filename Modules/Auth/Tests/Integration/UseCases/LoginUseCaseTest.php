<?php

namespace Modules\Auth\Tests\Integration\UseCases;

use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Entities\User;
use Tests\TestCase;
use Modules\Auth\UseCases\LoginUseCase;

class LoginUseCaseTest extends TestCase
{
    use RefreshDatabase;

    private string $password;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->password = '123';
        $encryptedPassword = Hash::make($this->password);

        $this->user = User::factory([
            'email' => 'correct@test.com',
            'password' => $encryptedPassword,
        ])->create();
    }

    /**
     * test perform() method
     *
     * @test
     */
    public function login_success(): void
    {
        $token = LoginUseCase::perform([
            'email' => $this->user->email,
            'password' => $this->password,
        ]);

        $this->assertNotNull($token);
    }

    /**
     * test perform() method
     *
     * @test
     */
    public function login_failed(): void
    {
        $this->expectExceptionMessage('Email or Password is not correct');

        LoginUseCase::perform([
            'email' => $this->user->email,
            'password' => 'wrong_password',
        ]);
    }
}
