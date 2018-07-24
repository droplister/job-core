<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HiringPathsController extends Controller
{
    /**
     * Hiring Path Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Hiring Paths
        $paths = \Droplister\JobCore\App\HiringPaths::index()->get();

        // Get Chunks
        $chunks = null;

        return view('job-core::paths.index', compact('paths', 'chunks'));
    }

    /**
     * Show Hiring Path
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $hiring)
    {
        // Get Hiring Path
        $path = \Droplister\JobCore\App\HiringPaths::findBySlugOrFail($hiring);

        // Get Listings
        $listings = $path->listings()->paginate(config('job-core.per_page'));

        // Get Parent
        $parent = null;

        // Get Children
        $children = \Droplister\JobCore\App\HiringPaths::related()->get();

        return view('job-core::paths.show', compact('path', 'listings', 'parent', 'children'));
    }
}
