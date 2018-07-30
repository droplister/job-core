<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\OccupationalSeries;
use JobApis\Jobs\Client\Queries\JujuQuery;
use JobApis\Jobs\Client\Providers\JujuProvider;

class MostController extends Controller
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
                    ->has('listings', '>=', config('job-core.min_listings'))
                    ->orderBy('value', 'desc')
                    ->get();
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

        return view('job-core::most.index', compact('listings', 'sponsored', 'children'));
    }
}
