<?php

namespace Droplister\JobCore\App\Traits;

use Droplister\JobCore\App\Location;
use Droplister\JobCore\App\AgencySubElements;
use JobApis\Jobs\Client\Queries\JujuQuery;
use JobApis\Jobs\Client\Providers\JujuProvider;

trait SponsoredListings
{
    /**
     * Sponsored Listings
     * https://github.com/jobapis/jobs-juju
     *
     * @return array
     */
    public function sponsoredListings()
    {
        // Sponsored Listings
        try
        {
            // Query
            $query = $this->queryKeyword();

            // Client
            $client = new JujuProvider($query);

            // Get Jobs
            return $client->getJobs()->orderBy('datePosted');
        }
        catch(\Exception $e)
        {
            return null;
        }
    }

    /**
     * Build Query
     */
    private function queryKeyword()
    {
        $query = new JujuQuery([
            'partnerid' => config('job-core.partner_id')
        ]);

        $query = $this->keywordFilter($query);

        return $query->set('highlight', '0');
    }

    /**
     * Set Filters
     */
    private function keywordFilter($query)
    {
        $keywords = [$this->value, config('job-core.keyword_root')];

        if($this instanceof AgencySubElements)
        {
            return $query->set('k', $keywords[0]);
        }
        elseif($this instanceof Location)
        {
            return $query->set('k', $keywords[1])
                ->set('l', $this->title);
        }

        return $query->set('k', implode(' ', $keywords));
    }
}