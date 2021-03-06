<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\OccupationalSeries;
use Droplister\JobCore\App\Traits\SponsoredListings;
use JobApis\Jobs\Client\Queries\JujuQuery;
use JobApis\Jobs\Client\Providers\JujuProvider;

use Cache, Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecificController extends Controller
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
        // Get Listings
        $listings = Cache::remember('specific_index_' . $request->input('page', 1), 1440,
            function () use ($request) {
                return Listing::specific()->paginate(config('job-core.max_listings'));
            }
        );

        // Get Children
        $children = Cache::remember('specific_index_children', 1440,
            function () {
                return OccupationalSeries::whereHas('listings',
                        function ($listing) {
                            $listing->specific();
                        }
                    )
                    ->withCount('listings')
                    ->has('listings', '>=', config('job-core.min_listings'))
                    ->orderBy('value', 'asc')
                    ->get();
            }
        );

        // Sponsored Listings
        $sponsored = $this->sponsoredListings();

        return view('job-core::specific.index', compact('listings', 'sponsored', 'children'));
    }
}
