<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\Location;
use Droplister\JobCore\App\PositionSchedule;
use Droplister\JobCore\App\SecurityClearances;
use JobApis\Jobs\Client\Queries\JujuQuery;
use JobApis\Jobs\Client\Providers\JujuProvider;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Keyword
        $keyword = $request->has('q') ? $request->q : config('job-core.keyword');

        // Get Subtitle
        $subtitle = $request->has('q') ? 'Results for "' . $request->q . '"' : 'Results for Job Filter';

        // Get Listings
        $listings = Cache::remember('listings_index_' . serialize($request->all()), 1440,
            function () use ($request) {
                return Listing::filter($request->all())
                    ->paginateFilter(config('job-core.per_page'));
            }
        );

        // Get Locations
        $locations = Cache::remember('listings_index_locations_' . serialize($request->all()), 1440,
            function () use ($request) {
                return Location::whereHas('listings',
                    function ($listings) use ($request) {
                        return $listings->filter($request->all());
                    }
                );
            }
        );

        // Get Schedules
        $schedules = Cache::remember('listings_index_schedules_' . serialize($request->all()), 1440,
            function () use ($request) {
                return PositionSchedule::whereHas('listings',
                    function ($listings) use ($request) {
                        return $listings->filter($request->all());
                    }
                );
            }
        );

        // Get Clearances
        $clearances = Cache::remember('listings_index_clearances_' . serialize($request->all()), 1440,
            function () use ($request) {
                return SecurityClearances::whereHas('listings',
                    function ($listings) use ($request) {
                        return $listings->filter($request->all());
                    }
                );
            }
        );

        // Sponsored Listings
        try
        {
            $query = new JujuQuery([
                'partnerid' => config('job-core.partner_id')
            ]);
            $query->set('k', $keyword)->set('highlight', '0');
            $client = new JujuProvider($query);
            $sponsored = $client->getJobs()->orderBy('datePosted');
        }
        catch(Exception $e)
        {
            $sponsored = null;
        }

        return view('job-core::search.index', compact('request', 'subtitle', 'listings', 'sponsored', 'locations', 'schedules', 'clearances'));
    }
}
