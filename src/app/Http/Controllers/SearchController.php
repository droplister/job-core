<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\Location;
use Droplister\JobCore\App\PayPlans;
use Droplister\JobCore\App\HiringPaths;
use Droplister\JobCore\App\TravelPercentage;
use Droplister\JobCore\App\PositionSchedule;
use Droplister\JobCore\App\AgencySubElements;
use Droplister\JobCore\App\SecurityClearances;
use Droplister\JobCore\App\OccupationalSeries;
use JobApis\Jobs\Client\Queries\JujuQuery;
use JobApis\Jobs\Client\Providers\JujuProvider;

use Cache, Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        // Get Agencies
        $agencies = Cache::remember('listings_index_agencies_' . serialize($request->all()), 1440,
            function () use ($request) {
                return AgencySubElements::narrow($request)->get();
            }
        );

        // Get Paths
        $paths = Cache::remember('listings_index_paths_' . serialize($request->all()), 1440,
            function () use ($request) {
                return HiringPaths::narrow($request)->get();
            }
        );

        // Get Locations
        $locations = Cache::remember('listings_index_locations_' . serialize($request->all()), 1440,
            function () use ($request) {
                return Location::isCity()->narrow($request)->get();
            }
        );

        // Get Careers
        $careers = Cache::remember('listings_index_careers_' . serialize($request->all()), 1440,
            function () use ($request) {
                return OccupationalSeries::narrow($request)->get();
            }
        );

        // Get Plans
        $plans = Cache::remember('listings_index_plans_' . serialize($request->all()), 1440,
            function () use ($request) {
                return PayPlans::narrow($request)->get();
            }
        );

        // Get Clearances
        $clearances = Cache::remember('listings_index_clearances_' . serialize($request->all()), 1440,
            function () use ($request) {
                return SecurityClearances::narrow($request)->get();
            }
        );

        // Get Schedules
        $schedules = Cache::remember('listings_index_schedules_' . serialize($request->all()), 1440,
            function () use ($request) {
                return PositionSchedule::narrow($request)->get();
            }
        );

        // Get Travel %
        $travels = Cache::remember('listings_index_travels_' . serialize($request->all()), 1440,
            function () use ($request) {
                return TravelPercentage::narrow($request)->get();
            }
        );

        // Show Filters
        $show_filters = count($careers) + count($agencies) + count($locations) + count($schedules) + count($clearances) + count($paths) + count($plans) + count($travels) > 0;

        // Sponsored Listings
        try
        {
            $query = new JujuQuery([
                'partnerid' => config('job-core.partner_id')
            ]);

            $query->set('channel', config('job-core.domain'));

            $query->set('k', $keyword)->set('highlight', '0');

            $client = new JujuProvider($query);

            $sponsored = $client->getJobs()->orderBy('datePosted');
        }
        catch(Exception $e)
        {
            $sponsored = null;
        }

        return view('job-core::search.index', compact('request', 'listings', 'sponsored', 'agencies', 'careers', 'locations', 'schedules', 'clearances', 'paths', 'plans', 'travels', 'show_filters'));
    }
}
