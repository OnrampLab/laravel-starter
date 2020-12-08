<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Account\Repositories\AccountRepository;
use Modules\Auth\Entities\User;
use Modules\Auth\Services\CreateUserService;

class UserSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(CreateUserService $createUserService, AccountRepository $accountRepository)
    {
        $userService = app(CreateUserService::class);
        $account = $accountRepository->first();
        $userData = [
            'name' => 'System Admin',
            'email' => 'admin@laravel-starter.com',
            'password' => 'admin',
            'roles' => ['system-admin'],
            'accounts' => [$account->id],
        ];

        $user = $userService->perform($userData);
    }
}
