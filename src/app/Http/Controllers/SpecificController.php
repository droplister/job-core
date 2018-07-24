<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecificController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listings = \Droplister\JobCore\App\Listing::specific()->paginate(config('job-core.max_listings'));

        $parent = null;

        if(config('job-core.filter') === 'security_clearance')
        {
            $children = \Droplister\JobCore\App\AgencySubElements::whereHas('listings', function($listing) {
                    $listing->specific();
                })
                ->withCount('listings')
                ->orderBy('listings_count', 'desc')
                ->take(config('job-core.max_relations'))
                ->get();
        }
        else
        {
            $children = \Droplister\JobCore\App\OccupationalSeries::whereHas('listings', function($listing) {
                    $listing->most();
                })
                ->withCount('listings')
                ->orderBy('listings_count', 'desc')
                ->take(config('job-core.max_relations'))
                ->get();
        }

        return view('job-core::specific.index', compact('listings', 'parent', 'children'));
    }
}
