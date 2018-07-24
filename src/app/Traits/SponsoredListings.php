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

        if(isset($this->value))
        {
        	$keyword = $this->value;
        }
        elseif(isset($this->name))
        {
        	$keyword = $this->name;
        }
        else
        {
        	$keyword = 'Federal Government Jobs';
        }

        $query->set('k', $keyword);

        $client = new \JobApis\Jobs\Client\Providers\JujuProvider($query);

        return $client->getJobs();
    }
}