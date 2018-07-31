<?php

namespace Droplister\JobCore\App\Console\Commands;

use Notification;
use Droplister\JobCore\App\Alert;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\Notifications\JobAlert;
use Illuminate\Console\Command;

class UsaJobsSendAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usajobs:alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Job Alerts';

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
    	// Active Alerts
		$alerts = Alert::whereHas('activeUsers')
		    ->with('activeUsers')
		    ->get();

		// Foreach Alert 
		foreach($alerts as $alert)
		{
			// Get Listings (Last 24 Hours)
		    $listings = Listing::isNew()->filter($alert->filters)->get();

		    // Send Notification
		    if(count($listings) > 0)
		    {
		    	Notification::send($alert->activeUsers, new JobAlert($alert, $listings));	
		    }
		}
    }
}