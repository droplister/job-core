<?php

namespace Droplister\JobCore\App\Console\Commands;

use Illuminate\Console\Command;

class CoreClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Job Core';

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
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
    }
}