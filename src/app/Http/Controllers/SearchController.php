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
use Droplister\JobCore\App\Traits\SponsoredListings;
use JobApis\Jobs\Client\Queries\JujuQuery;
use JobApis\Jobs\Client\Providers\JujuProvider;

use Cache, Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    use SponsoredListings;

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Subtitle
        $subtitle = $request->has('q') ? 'Results for "' . $request->q . '"' : 'Results for Job Filter';

        // Get Listings
        $listings = Cache::remember('listings_index_' . serialize($request->all()), 1440,
            function () use ($request) {
                return Listing::filter($request->all())
                    ->paginateFilter(config('job-core.per_page'));
            }
        );

        // Get Ages
        $days_ago = [1, 3, 7, 30];

        // Get Paths
        $paths = Cache::remember('listings_index_paths_' . serialize($request->all()), 1440,
            function () use ($request) {
                return HiringPaths::narrow($request)->get();
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
        $show_filters = count($schedules) + count($paths) + count($travels) > 0;

        // Sponsored Listings
        $sponsored = $this->sponsoredListings($request);

        return view('job-core::search.index', compact('request', 'subtitle', 'listings', 'sponsored', 'days_ago', 'schedules', 'paths', 'travels', 'show_filters'));
    }
}
