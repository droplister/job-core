<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\SecurityClearances;
use JobApis\Jobs\Client\Queries\JujuQuery;
use JobApis\Jobs\Client\Providers\JujuProvider;
use Droplister\JobCore\App\Traits\GuardsAgainst;

class ListingsController extends Controller
{
    use GuardsAgainst;

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
                return [];
                // return SecurityClearances::related()->get();
            }
        );

        // Sponsored Listings
        try
        {
            $query = new JujuQuery([
                'partnerid' => config('job-core.partner_id')
            ]);

            $query->set('k', config('job-core.keyword'))->set('highlight', '0');

            $client = new JujuProvider($query);

            $sponsored = $client->getJobs()->orderBy('datePosted');
        }
        catch(Exception $e)
        {
            $sponsored = null;
        }

        return view('job-core::listings.index', compact('listings', 'sponsored', 'children'));
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
}
