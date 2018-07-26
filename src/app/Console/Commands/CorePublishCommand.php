<?php

namespace Droplister\JobCore\App\Console\Commands;

use Illuminate\Console\Command;

class CorePublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Job Core';

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
        $this->call('vendor:publish', ['--provider' => 'Droplister\\JobCore\\JobCoreServiceProvider']);
        $this->call('vendor:publish', ['--tag' => 'job-core']);
    }
}