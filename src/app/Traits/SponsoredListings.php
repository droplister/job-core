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
        $query = new \JobApis\Jobs\Client\Queries\JujuQuery([
            'partnerid' => config('job-core.partner_id')
        ]);

        if($this instanceof \Droplister\JobCore\App\Location)
        {
            $query->set('k', config('job-core.keyword_root'))
                  ->set('highlight', '0')
                  ->set('l', $this->title);
        }
        elseif($this instanceof \Droplister\JobCore\App\AgencySubElements)
        {
            $query->set('k', $this->value)
                  ->set('highlight', '0');
        }
        else
        {
            $keyword = $this->value . ' ' . config('job-core.keyword_root');

            $query->set('k', $keyword)
                  ->set('highlight', '0');
        }

        $client = new \JobApis\Jobs\Client\Providers\JujuProvider($query);

        try
        {
            return $client->getJobs()->orderBy('datePosted');
        }
        catch(\Exception $e)
        {
            return null;
        }
    }
}