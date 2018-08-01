<?php

namespace Droplister\JobCore\App\Console\Commands;

use Droplister\JobCore\App\Listing;

use Illuminate\Console\Command;

class UsaJobsPruneDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usajobs:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune Jobs';

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
        $active_ids = Listing::listingsFilter()
            ->pluck('id')
            ->all();

        $closed_ids = Listing::listingsFilter(false)
            ->pluck('id')
            ->all();

        Listing::whereNotIn('id', $active_ids)
            ->whereNotIn('id', $closed_ids)
            ->delete();
    }
}