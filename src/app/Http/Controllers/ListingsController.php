<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListingsController extends Controller
{
    /**
     * Listings Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Listings
        $listings = Droplister\JobCore\App\Listing::index()->paginate(config('job-core.per_page'));

        // Get Children
        $children = Droplister\JobCore\App\SecurityClearances::related()->get();

        return view('listings.index', compact('listings', 'children'));
    }

    /**
     * Show Listing
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $listing)
    {
        // Get Listing
        $listing = Droplister\JobCore\App\Listing::findBySlugOrFail($listing);

        // Filter Show
        if(! Droplister\JobCore\App\Listing::listingFilter()->get()->contains($listing))
        {
            return abort(404);
        }

        // Get Listings
        $listings = Droplister\JobCore\App\Listing::related($listing)->get();
        
        return view('listings.show', compact('listing', 'listings'));
    }
}
