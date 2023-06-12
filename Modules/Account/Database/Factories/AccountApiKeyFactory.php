<?php

namespace Modules\Account\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Account\Entities\AccountApiKey;

/**
 * @extends Factory<AccountApiKey>
 */
class AccountApiKeyFactory extends Factory
{
    protected $model = AccountApiKey::class;

    public function definition(): array
    {
        return [
            'account_id' => $this->faker->randomDigit(),
            'token' => $this->faker->lexify('?????'),
        ];
    }
}
