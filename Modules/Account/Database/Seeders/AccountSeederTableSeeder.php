<?php

namespace Modules\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Account\Entities\Account;

class AccountSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Account::create(['name' => 'Default Account']);
    }
}
