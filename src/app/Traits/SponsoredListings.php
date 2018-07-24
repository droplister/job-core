<?php

namespace Droplister\JobCore\App\Traits;

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
        $keyword = isset($this->value) ? $this->value : $this->name;

        $keyword = $keyword . ' ' . config('job-core.keyword_root');

        $query = new \JobApis\Jobs\Client\Queries\JujuQuery([
            'partnerid' => config('job-core.partner_id')
        ]);

        $query->set('k', $keyword);

        $client = new \JobApis\Jobs\Client\Providers\JujuProvider($query);

        try
        {
            return $client->getJobs();
        }
        catch(\Exception $e)
        {
            return null;
        }
    }
}