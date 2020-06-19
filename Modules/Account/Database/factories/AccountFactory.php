<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Modules\Account\Entities\Account;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'name' => $faker->lexify('?????'),
        'parent_id' => null,
    ];
});
