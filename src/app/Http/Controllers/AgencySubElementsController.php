<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgencySubElementsController extends Controller
{
    /**
     * Ageny Sub Elements Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Agencies
        $agencies = \Cache::remember('agencies_index', 1440, function () {
            return \Droplister\JobCore\App\AgencySubElements::index()->get();
        });

        // Chunk Size
        $chunk_size = ceil(count($agencies) / 3);

        // Get Chunks
        $chunks = $agencies->chunk($chunk_size);

        return view('job-core::agencies.index', compact('agencies', 'chunks'));
    }

    /**
     * Show Ageny Sub Elements
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $agency)
    {
        // Get Agency
        $agency = \Droplister\JobCore\App\AgencySubElements::findBySlugOrFail($agency);

        // Get Listings
        $listings = $agency->listings()->paginate(config('job-core.per_page'));

        // Get Parent
        $parent = $agency->parent;

        // Get Children
        if($agency->parent_code && ! $agency->children()->exists())
        {
            // Parent Children
            $children = $parent->related()->get();
        }
        else
        {
            // Agency Children
            $children = $agency->related()->get();
        }

        // Sponsored Jobs
        $sponsored = $agency->sponsoredListings();

        return view('job-core::agencies.show', compact('agency', 'listings', 'parent', 'children', 'sponsored'));
    }
}
