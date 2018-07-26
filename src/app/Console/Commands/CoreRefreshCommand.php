<?php

namespace Droplister\JobCore\App\Console\Commands;

use Illuminate\Console\Command;

class CoreRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Job Core';

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
        $this->call('core:clear');
        $this->call('core:cache');
    }
}