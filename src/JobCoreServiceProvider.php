<?php

namespace Droplister\JobCore;

use Illuminate\Support\ServiceProvider;

class JobCoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Assets
         */
        $this->publishes([
            __DIR__ . '/../resources/assets' => resource_path('assets/droplister/job-core',
        )], 'job-core');

        /**
         * Commands
         */
        if ($this->app->runningInConsole())
        {
            $this->commands([
                App\Console\Commands\CoreCacheCommand::class,
                App\Console\Commands\CoreClearCommand::class,
                App\Console\Commands\CoreInstallCommand::class,
                App\Console\Commands\CoreReinstallCommand::class,
                App\Console\Commands\CoreRefreshCommand::class,
                App\Console\Commands\CoreUpdateCommand::class,
                App\Console\Commands\UsaJobsFetchDaily::class,
                App\Console\Commands\UsaJobsFetchTravel::class,
                App\Console\Commands\UsaJobsFetchInterns::class,
                App\Console\Commands\UsaJobsFetchMilitary::class,
                App\Console\Commands\UsaJobsFetchSecurity::class,
            ]);
        }

        /**
         * Configuration
         */
        $this->publishes([
            __DIR__.'/config' => config_path(''),
        ], 'job-core');

        /**
         * Migrations
         */
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        /**
        * Routes
        */
        $this->app->router->group(['namespace' => 'Droplister\JobCore\App\Http\Controllers'],
            function() {
                require __DIR__.'/routes/api.php';
            }
        );

        /**
        * Routes
        */
        $this->app->router->group(['namespace' => 'Droplister\JobCore\App\Http\Controllers'],
            function() {
                require __DIR__.'/routes/web.php';
            }
        );

        /**
        * Views
        */
        $this->loadViewsFrom(__DIR__.'/resources/views', 'job-core');
        // $this->publishes([
        //     __DIR__.'/resources/views' => resource_path('views/vendor/job-core'),
        // ], 'job-core');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}