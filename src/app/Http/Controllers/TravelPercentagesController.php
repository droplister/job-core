<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TravelPercentagesController extends Controller
{
    /**
     * Travel % Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Travels
        $travels = \Droplister\JobCore\App\TravelPercentage::index()->get();

        // Get Chunks
        $chunks = null;

        return view('job-core::travels.index', compact('travels', 'chunks'));
    }

    /**
     * Show Travel %
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $travel)
    {
        // Get Travel
        $travel = \Droplister\JobCore\App\TravelPercentage::findBySlugOrFail($travel);

        //  Get Listings
        $listings = $travel->listings()->paginate(config('job-core.per_page'));

        // Get Parent
        $parent = null;

        // Get Children
        $children = \Droplister\JobCore\App\TravelPercentage::related()->get();

        return view('job-core::travels.show', compact('travel', 'listings', 'parent', 'children'));
    }
}
