<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MostController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listings = \Droplister\JobCore\App\Listing::most()->paginate(config('job-core.max_listings'));

        $parent = null;

        $children = \Droplister\JobCore\App\OccupationalSeries::whereHas('listings', function($listing) {
                $listing->most();
            })
            ->withCount('listings')
            ->orderBy('listings_count', 'desc')
            ->has('listings', '>=', config('job-core.min_listings'))
            ->get();

        return view('job-core::most.index', compact('listings', 'parent', 'children'));
    }
}
