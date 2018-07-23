<?php

namespace Droplister\JobCore\App\Console\Commands;

use Illuminate\Console\Command;

class CoreCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache Job Core';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
    }
}