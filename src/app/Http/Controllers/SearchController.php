<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;
use JobApis\Jobs\Client\Queries\JujuQuery;
use JobApis\Jobs\Client\Providers\JujuProvider;

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
        $listings = Cache::remember('search_index_' . serialize($request->all()), 1440,
            function () use ($request) {
                return Listing::filter($request->all())
                    ->paginateFilter(config('job-core.per_page'));
            }
        );

        // Sponsored Listings
        try
        {
            $query = new JujuQuery([
                'partnerid' => config('job-core.partner_id')
            ]);
            $query->set('k', $keyword)->set('highlight', '0');
            $client = new JujuProvider($query);
            $sponsored = $client->getJobs()->orderBy('datePosted');
        }
        catch(Exception $e)
        {
            $sponsored = null;
        }

        return view('job-core::search.index', compact('request', 'subtitle', 'listings', 'sponsored'));
    }
}
