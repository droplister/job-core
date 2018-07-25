<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\OccupationalSeries;

class MostController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Listings
        $listings = Cache::remember('most_index_' . $request->input('page', 1), 1440,
            function () use ($request) {
                return Listing::most()->paginate(config('job-core.max_listings'));
            }
        );

        // Get Children
        $children = Cache::remember('most_index_children', 1440,
            function () {
                return OccupationalSeries::whereHas('listings',
                        function ($listing) {
                            $listing->most();
                        }
                    )
                    ->withCount('listings')
                    ->orderBy('listings_count', 'desc')
                    ->has('listings', '>=', config('job-core.min_listings'))
                    ->get();
            }
        );

        return view('job-core::most.index', compact('listings', 'children'));
    }
}
