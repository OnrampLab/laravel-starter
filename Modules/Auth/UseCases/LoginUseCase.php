<?php

namespace Modules\Auth\UseCases;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\UseCases\Commands\LoginCommand;
use OnrampLab\CleanArchitecture\Exceptions\CustomDomainException;
use OnrampLab\CleanArchitecture\UseCase;

class LoginUseCase extends UseCase
{
    public LoginCommand $command;

    public function handle(): string
    {
        // TODO: should not call infrastructure layer in use case
        $token = Auth::attempt($this->command->toArray());

        if (! $token) {
            throw new CustomDomainException(
                'Unable To Login',
                'Email or Password is not correct',
                [],
                401,
                new AuthenticationException('Unauthenticated.'),
            );
        }

        return (string) $token;
    }
}
