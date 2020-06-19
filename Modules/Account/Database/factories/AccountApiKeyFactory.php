<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Modules\Account\Entities\AccountApiKey;

$factory->define(AccountApiKey::class, function (Faker $faker) {
    return [
        'account_id' => $faker->randomDigit(),
        'token' => $faker->lexify('?????'),
    ];
});
