<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\HiringPaths;

class HiringPathsController extends Controller
{
    /**
     * Hiring Path Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Hiring Paths
        $paths = Cache::remember('paths_index', 1440,
            function () {
                return HiringPaths::index()->get();
            }
        );

        return view('job-core::paths.index', compact('paths'));
    }

    /**
     * Show Hiring Path
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $path)
    {
        // Get Hiring Path
        $path = Cache::remember('paths_show_' . $path, 1440,
            function () use ($path) {
                return HiringPaths::findBySlugOrFail($path);
            }
        );

        // Get Listings
        $listings = Cache::remember('paths_show_' . $path->slug . '_listings_' . $request->input('page', 1), 1440,
            function () use ($request, $path) {
                return $path->listings()->paginate(config('job-core.per_page'));
            }
        );

        // Sponsored Jobs
        $sponsored = Cache::remember('paths_show_' . $path->slug . '_sponsored', 1440,
            function () use ($path) {
                return $path->sponsoredListings();
            }
        );

        // Get Children
        $children = Cache::remember('paths_show_children', 1440,
            function () {
                return HiringPaths::related()->get();
            }
        );

        return view('job-core::paths.show', compact('path', 'listings', 'sponsored', 'children'));
    }
}
