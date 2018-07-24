<?php

namespace Droplister\JobCore\App\Console\Commands;

use Illuminate\Console\Command;

class UsaJobsFetchInterns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usajobs:interns';

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
        // Method 1
        $listings = Droplister\JobCore\App\Listing::where('who_may_apply', 'like', '%student%')
            ->orWhere('position_offering_type', 'like', '%intern%')
            ->orWhere('position_title', 'like', '% internship %')
            ->orWhere('position_title', 'like', 'internship %')
            ->orWhere('position_title', 'like', '% internship')
            ->orWhere('position_title', 'like', '% student %')
            ->orWhere('position_title', 'like', 'student %')
            ->orWhere('position_title', 'like', '% student')
            ->get();

        $this->flagInternships($listings);

        // Method 2
        $careers = Droplister\JobCore\App\OccupationalSeries::where('value', 'like', '% Student Trainee')->get();

        foreach ($careers as $career)
        {
            $this->flagInternships($career->listings);
        }

        // Method 3
        $path = \App\HiringPaths::findBySlug('students');

        $this->flagInternships($path->listings);

        // Comment
        $this->comment("Processed Internships");
    }

    /**
     * Re-useable Loop
     *
     * @return void
     */
    private function flagInternships($listings)
    {
        foreach ($listings as $listing)
        {
            $listing->update(['internship_flag' => 1]);
        }
    }
}