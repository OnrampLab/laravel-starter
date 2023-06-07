<?php

namespace Modules\Auth\UseCases;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use OnrampLab\CleanArchitecture\Exceptions\CustomDomainException;
use OnrampLab\CleanArchitecture\UseCase;
use Spatie\LaravelData\Attributes\Validation\Email;

class LoginUseCase extends UseCase
{
    #[Email()]
    public string $email;

    public string $password;

    public function handle(): string
    {
        // TODO: should not call infrastructure layer in use case
        $token = Auth::attempt($this->toArray());

        if (! $token) {
            throw new CustomDomainException(
                'Unable To Login',
                'Email or Password is not correct',
                [],
                401,
                new AuthenticationException('Unauthenticated.')
            );
        }

        return $token;
    }
}
