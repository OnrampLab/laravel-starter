<?php

declare(strict_types=1);

namespace OnrampLab\Hello;

use Illuminate\Support\ServiceProvider;

class HelloServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->registerCommands();
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------
    /**
     * Register the Artisan commands.
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\SayHiCommand::class,
            ]);
        }
    }
}
