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
        $agencies = \Cache::remember('agencies_index', 1440,
            function () {
                return \Droplister\JobCore\App\AgencySubElements::index()->get();
            }
        );

        // Get Chunks
        $chunks = \Cache::remember('agencies_index_chunks', 1440,
            function () use ($agencies) {
                $chunk_size = ceil(count($agencies) / 3);

                return $agencies->chunk($chunk_size);
            }
        );

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
        $agency = \Cache::remember('agencies_show_' . $agency, 1440,
            function () use ($slug) {
                return \Droplister\JobCore\App\AgencySubElements::findBySlugOrFail($slug);
            }
        );

        // Get Listings
        $listings = \Cache::remember('agencies_show_' . $agency->id . '_listings_' . $request->input('page', 1), 1440,
            function () use ($agency) {
                return $agency->listings()->paginate(config('job-core.per_page'));
            }
        );

        // Sponsored Jobs
        $sponsored = \Cache::remember('agencies_show_' . $agency->id . '_sponsored', 1440,
            function () use ($agency) {
                return $agency->sponsoredListings();
            }
        );

        // Get Parent
        $parent = \Cache::remember('agencies_show_' . $agency->id . '_parent', 1440,
            function () use ($agency) {
                return $agency->parent;
            }
        );

        // Get Children
        $children = \Cache::remember('agencies_show_' . $agency->id . '_children', 1440,
            function () use ($agency, $parent) {
                if($parent && ! $agency->children()->exists())
                {
                    // Parent Children
                    return $parent->related()->get();
                }
                else
                {
                    // Agency Children
                    return $agency->related()->get();
                }
            }
        );

        return view('job-core::agencies.show', compact('agency', 'listings', 'sponsored', 'parent', 'children'));
    }
}
