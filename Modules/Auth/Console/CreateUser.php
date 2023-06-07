<?php

namespace Modules\Auth\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Modules\Auth\Services\CreateUserService;

class CreateUser extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'auth:create-user
                            {name : Name of the user}
                            {email : Email of the user}
                            {role : Role of the user}
                            {account : Accessed account ID of the user}
                            {password? : Password of the user, will generate a random password if not given}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user.';

    /**
     * @var CreateUserService
     */
    protected $createUserService;

    /**
     * Create a new command instance.
     */
    public function __construct(CreateUserService $createUserService)
    {
        parent::__construct();

        $this->createUserService = $createUserService;
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
            'roles' => [$this->argument('role')],
            'accounts' => [$this->argument('account')],
            'password' => $this->argument('password') ?? $randomPassword,
        ];

        $this->createUserService->perform($userData);

        $this->info('User created, password: ' . $userData['password']);
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
