<?php

namespace Modules\Auth\UseCases\Commands;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;

class LoginCommand extends Data
{
    public function __construct(
        #[Email()]
        public string $email,
        public string $password,
    ) {
    }
}
