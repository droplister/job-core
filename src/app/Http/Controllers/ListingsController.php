<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\SecurityClearances;

class ListingsController extends Controller
{
    /**
     * Listings Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Listings
        $listings = Cache::remember('listings_index', 1440,
            function () use ($request) {
                return Listing::index()->paginate(config('job-core.per_page'));
            }
        );

        // Get Children
        $children = Cache::remember('listings_index_children', 1440,
            function () {
                return SecurityClearances::related()->get();
            }
        );
        return view('job-core::listings.index', compact('listings', 'children'));
    }

    /**
     * Show Listing
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $listing)
    {
        // Get Listing
        $listing = Cache::remember('listings_show_' . $listing, 1440,
            function () use ($listing) {
                return Listing::findBySlugOrFail($listing);
            }
        );

        // Filter Show
        if(! Listing::listingFilter()->get()->contains($listing))
        {
            return abort(404);
        }

        // Get Listings
        $listings = Cache::remember('listings_show_' . $listing->slug . '_listings', 1440,
            function () use ($listing) {
                return Listing::related($listing)->get();
            }
        );

        return view('job-core::listings.show', compact('listing', 'listings'));
    }
}
