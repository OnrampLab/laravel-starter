<?php

namespace Modules\Auth\Console;

use Hash;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Modules\Auth\Services\UserService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateUser extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'auth:create-user {name} {email} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user.';

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $randomPassword = Str::random(8);
        $userData = [
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password') ?? $randomPassword,
        ];

        $this->userService->createUser($userData);

        $this->info('User created, password: ' . $userData['password']);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Name of the user'],
            ['email', InputArgument::REQUIRED, 'Email of the user'],
            ['password', InputArgument::OPTIONAL, 'Password of the user, will generate a random password if not given'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }
}
