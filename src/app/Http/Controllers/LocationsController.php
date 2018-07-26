<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Location;

class LocationsController extends Controller
{
    /**
     * Locations Index
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Location
        $locations = Cache::remember('locations_index', 1440,
            function () {
                return Location::index()->get();
            }
        );

        // Get Chunks
        $chunks = Cache::remember('locations_index_chunks', 1440,
            function () use ($locations) {
                $chunk_size = ceil(count($locations) / 4);

                return $locations->chunk($chunk_size);
            }
        );

        // Get Coordinates
        $google_map = config('job-core.google_map');

        return view('job-core::locations.index', compact('locations', 'chunks', 'google_map'));
    }

    /**
     * Show Location
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $location)
    {
        // Get Location
        $location = Cache::remember('locations_show_' . $location, 1440,
            function () use ($location) {
                return Location::findBySlugOrFail($location);
            }
        );
        // Get Listings
        $listings = Cache::remember('locations_show_' . $location->slug . '_listings_' . $request->input('page', 1), 1440,
            function () use ($request, $location) {
                return $location->listings()->paginate(config('job-core.per_page'));
            }
        );

        // Sponsored Jobs
        $sponsored = Cache::remember('locations_show_' . $location->slug . '_sponsored', 1440,
            function () use ($location) {
                return $location->sponsoredListings();
            }
        );

        // Get Parent
        $parent = Cache::remember('locations_show_' . $location->slug . '_parent', 1440,
            function () use ($location) {
                return $location->parent;
            }
        );

        // Get Children
        $children = Cache::remember('locations_show_' . $location->slug . '_children', 1440,
            function () use ($location, $parent) {
                if($location->type === 'city')
                {
                    // Parent Children
                    return $parent->related()->get();
                }
                else
                {
                    // Location Children
                    return $location->related()->get();
                }
            }
        );

        return view('job-core::locations.show', compact('location', 'listings', 'sponsored', 'parent', 'children'));
    }
}
