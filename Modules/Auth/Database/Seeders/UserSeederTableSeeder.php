<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Account\Repositories\AccountRepository;
use Modules\Auth\Services\CreateUserService;

class UserSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(CreateUserService $createUserService, AccountRepository $accountRepository): void
    {
        $userService = app(CreateUserService::class);
        $account = $accountRepository->find(1);
        $userData = [
            'name' => 'System Admin',
            'email' => 'admin@laravel-starter.com',
            'password' => 'admin',
            'roles' => ['system-admin'],
            'accounts' => [$account->id],
        ];

        $userService->perform($userData);
    }
}
