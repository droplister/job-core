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
     * @param  \Illuminate\Http\Request  $request
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
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $listing
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
        if($this->guardAgainstDisabledListings($listing))
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

    /**
     * Check Filter Applies
     * 
     * @param  \Droplister\JobCore\App\Listing  $listing
     * @return boolean
     */
    private function guardAgainstDisabledListings(Listing $listing)
    {
        return Cache::remember('listing_is_enabled_' . $listing->slug, 1440,
            function () use ($listing) {
                return ! Listing::listingFilter()->get()->contains($listing);
            }
        );
    }
}
