<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\OccupationalSeries;

class SpecificController extends Controller
{
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
                    ->orderBy('listings_count', 'desc')
                    ->get();
            }
        );

        return view('job-core::specific.index', compact('listings', 'children'));
    }
}
