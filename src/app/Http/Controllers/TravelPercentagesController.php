<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\TravelPercentage;

class TravelPercentagesController extends Controller
{
    /**
     * Travel % Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Travels
        $travels = Cache::remember('travels_index', 1440,
            function () {
                return TravelPercentage::index()->get();
            }
        );

        return view('job-core::travels.index', compact('travels'));
    }

    /**
     * Show Travel %
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $travel)
    {
        // Get Travel
        $travel = Cache::remember('travels_show_' . $travel, 1440,
            function () use ($travel) {
                return TravelPercentage::findBySlugOrFail($travel);
            }
        );

        // Get Listings
        $listings = Cache::remember('travels_show_' . $travel->slug . '_listings_' . $request->input('page', 1), 1440,
            function () use ($request, $travel) {
                return $travel->listings()->paginate(config('job-core.per_page'));
            }
        );

        // Sponsored Jobs
        $sponsored = Cache::remember('travels_show_' . $travel->slug . '_sponsored', 1440,
            function () use ($travel) {
                return $travel->sponsoredListings();
            }
        );

        // Get Children
        $children = Cache::remember('travels_show_children', 1440,
            function () {
                return TravelPercentage::related()->get();
            }
        );

        return view('job-core::travels.show', compact('travel', 'listings', 'sponsored', 'children'));
    }
}
