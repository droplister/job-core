<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationsController extends Controller
{
    /**
     * Locations Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Location
        $locations = \Droplister\JobCore\App\Location::index()->get();

        // Get Coordinates
        $google_map = config('job-core.google_map');

        // Chunk Size
        $chunk_size = ceil(count($locations) / 4);

        // Get Chunks
        $chunks = $locations->chunk($chunk_size);

        return view('locations.index', compact('locations', 'chunks', 'google_map'));
    }

    /**
     * Show Location
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $location)
    {
        // Get Location
        $location = \Droplister\JobCore\App\Location::findBySlugOrFail($location);

        // Get Listings
        $listings = $location->listings()->paginate(config('job-core.per_page'));

        // Get Parent
        $parent = $location->parent;

        // Get Children
        if($location->type === 'city')
        {
            // Parent Children
            $children = $parent->related()->get();
        }
        else
        {
            // Location Children
            $children = $location->related()->get();
        }

        return view('locations.show', compact('location', 'listings', 'parent', 'children'));
    }
}
