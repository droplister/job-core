<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;

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
        // Get Query
        $listings = Listing::filter($request->all())->paginate(config('job-core.per_page'));

        // Get Keyword
        $keyword = $request->has('q') ? $request->q : config('job-core.keyword');

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

        $subtitle = $request->has('q') ? 'Results for "' . $request->q . '"' : 'Results for Job Filter';

        return view('job-core::search.index', compact('request', 'subtitle', 'listings', 'sponsored'));
    }
}
