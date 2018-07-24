<?php

namespace Droplister\JobCore\App\Console\Commands;

use Illuminate\Console\Command;

class UsaJobsFetchMilitary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usajobs:military';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch USAJobs.gov API';

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
        $listings = \Droplister\JobCore\App\Listing::whereHas('locations', function($location) {
                return $location->isMilitaryBase();
            })->get();

        $this->flagMilitaryBases($listings);

        $this->comment("Processed Military Base Jobs");
    }

    /**
     * Re-useable Loop
     *
     * @return void
     */
    private function flagMilitaryBases($listings)
    {
        foreach ($listings as $listing)
        {
            $listing->update(['military_base_flag' => 1]);
        }
    }
}