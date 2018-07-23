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
         * Commands
         */
        if ($this->app->runningInConsole())
        {
            $this->commands([
                Droplister\JobCore\App\Console\Commands\CoreCacheCommand::class,
                Droplister\JobCore\App\Console\Commands\CoreClearCommand::class,
                Droplister\JobCore\App\Console\Commands\CoreInstallCommand::class,
                Droplister\JobCore\App\Console\Commands\CoreReinstallCommand::class,
                Droplister\JobCore\App\Console\Commands\CoreUpdateCommand::class,
                Droplister\JobCore\App\Console\Commands\UsaJobsFetchDaily::class,
                Droplister\JobCore\App\Console\Commands\UsaJobsFetchTravel::class,
                Droplister\JobCore\App\Console\Commands\UsaJobsFetchInterns::class,
                Droplister\JobCore\App\Console\Commands\UsaJobsFetchMilitary::class,
                Droplister\JobCore\App\Console\Commands\UsaJobsFetchSecurity::class,
            ]);
        }

        /**
         * Configuration
         */
        $this->publishes([
            __DIR__.'/config' => config_path('job-core.php'),
        ]);

        /**
         * Migrations
         */
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
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