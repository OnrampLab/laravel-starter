<?php

namespace OnrampLab\Hello\Console\Commands;

use Illuminate\Console\Command;

class SayHiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:sayhi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'hello';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): mixed
    {
        echo "hi!\n";
    }
}
