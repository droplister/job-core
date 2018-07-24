<?php

namespace Droplister\JobCore\App\Console\Commands;

use Illuminate\Console\Command;

class UsaJobsFetchSecurity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usajobs:security';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch USAJobs.gov API';

    /**
     * USAJobs.gov API
     *
     * @var Curl
     */
    protected $curl;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->curl = new \Curl\Curl();
        $this->curl->setHeader('Host', config('job-core.usajobs_host'));
        $this->curl->setHeader('User-Agent', config('job-core.usajobs_email'));
        $this->curl->setHeader('Authorization-Key', config('job-core.usajobs_key'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $clearances = \Droplister\JobCore\App\SecurityClearances::get();

        foreach ($clearances as $clearance)
        {
            $total_pages = $this->fetchApiPageCount($clearance->code);

            for ($current_page = 1; $current_page <= $total_pages; $current_page++)
            {
                $results = $this->fetchApiPageResults($clearance->code, $current_page);

                if(! $results) continue;

                foreach ($results->SearchResult->SearchResultItems as $result)
                {
                    $this->processResult($clearance, $result);
                }
            }

            $this->comment("Processed {$total_pages} page(s): {$clearance->value}");
        }
    }

    /**
     * Determine # of Pages
     *
     * @return integer
     */
    private function fetchApiPageCount($search)
    {
        $results = $this->fetchApiPageResults($search);

        // Catch Failed Fetch
        if (! $results) return false;

        return ceil($results->SearchResult->SearchResultCountAll / 500);
    }

    /**
     * Return API Results
     *
     * @return object
     */
    private function fetchApiPageResults($search, $page=1)
    {
        $this->curl->get('https://data.usajobs.gov/api/Search?Page='. $page .'&ResultsPerPage=500&SecurityClearanceRequired=' . $search);

        return json_decode($this->curl->response);
    }

    /**
     * Process Single Result
     *
     * @return void
     */
    private function processResult($clearance, $result)
    {
        // Find Listing
        $listing = \Droplister\JobCore\App\Listing::whereControlNumber(trim($result->MatchedObjectId))->first();

        if(! $listing) return false;

        // SecurityClearances
        $listing->clearances()->sync([$clearance->id], false);

        $listing->update(['clearance_code' => $clearance->code]);

        if(in_array($clearance->code, [1, 2, 3, 4, 5, 6, 7]))
        {
            $listing->update(['clearance_flag' => 1]);
        }
    }
}