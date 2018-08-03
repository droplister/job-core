<?php

namespace Droplister\JobCore\App\Traits;

use Exception;
use Droplister\JobCore\App\Location;
use Droplister\JobCore\App\AgencySubElements;
use Droplister\JobCore\App\Controllers\MostController;
use Droplister\JobCore\App\Controllers\SearchController;
use Droplister\JobCore\App\Controllers\SpecificController;
use Droplister\JobCore\App\Controllers\ListingsController;
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
    public function sponsoredListings($request=null)
    {
        // Sponsored Listings
        try
        {
            // Juju Query
            $query = $this->queryKeyword($request);

            // Juju Provider
            $provider = new JujuProvider($query);

            // Get Juju Jobs
            return $provider->getJobs()->orderBy('datePosted');
        }
        catch(Exception $e)
        {
            return null;
        }
    }

    /**
     * Build Query
     */
    private function queryKeyword($request)
    {
        return new JujuQuery([
            'highlight' => '0',
            'partnerid' => config('job-core.partner_id'),
            'channel' => strtolower(config('job-core.domain')),
            'k' => $this->keyword($request),
            'l' => $this->location(),
        ]);
    }

    /**
     * Get keyword.
     */
    private function keyword($request)
    {
        if($request && $request->has('q'))
        {
            return $request->has('q') ? $request->q : config('job-core.keyword');
        }
        elseif($this instanceof AgencySubElements)
        {
            return $this->value;
        }
        elseif($this instanceof Location)
        {
            return config('job-core.keyword_root');
        }
        elseif($this instanceof ListingsController ||
            $this instanceof MostController ||
            $this instanceof SearchController ||
            $this instanceof SpecificController)
        {
             return config('job-core.keyword');
        }

        return $this->value . ' ' . config('job-core.keyword_root');
    }

    /**
     * Get location.
     */
    private function location()
    {
        if($this instanceof Location)
        {
            return $this->title;
        }

        return '';
    }
}