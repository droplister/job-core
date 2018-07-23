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
        $listings = Droplister\JobCore\App\Listing::specific()->paginate(config('job-core.max_listings'));

        $parent = null;

        $children = Droplister\JobCore\App\AgencySubElements::whereHas('listings', function($listing) {
                $listing->specific();
            })
            ->withCount('listings')
            ->orderBy('listings_count', 'desc')
            ->take(config('job-core.max_relations'))
            ->get();

        return view('specific.index', compact('listings', 'parent', 'children'));
    }
}