<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Config;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path('Core', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/core');

        $sourcePath = module_path('Core', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/core';
        }, Config::get('view.paths')), [$sourcePath]), 'core');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/core');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'core');
        } else {
            $this->loadTranslationsFrom(module_path('Core', 'Resources/lang'), 'core');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Core', 'Config/config.php') => config_path('core.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Core', 'Config/config.php'),
            'core',
        );
    }
}
