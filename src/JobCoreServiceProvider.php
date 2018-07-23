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
         * Migrations
         */
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        /**
         * Configuration
         */
        $this->publishes([
            __DIR__.'/config' => config_path('job-core.php'),
        ]);
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