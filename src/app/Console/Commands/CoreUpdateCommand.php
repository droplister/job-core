<?php

namespace Droplister\JobCore\App\Console\Commands;

use Illuminate\Console\Command;

class CoreUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Job Core';

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
        $this->call('usajobs:daily');
        $this->call('usajobs:interns');
        $this->call('usajobs:military');
        $this->call('usajobs:security');
        $this->call('usajobs:travel');
    }
}
