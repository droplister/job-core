<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\SecurityClearances;

class SecurityClearancesController extends Controller
{
    /**
     * Security Clearance Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Levels
        $levels = Cache::remember('levels_index', 1440,
            function () {
                return SecurityClearances::index()->get();
            }
        );

        return view('job-core::levels.index', compact('levels'));
    }

    /**
     * Show Security Clearance
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $level)
    {
        // Get Level
        $level = Cache::remember('levels_show_' . $level, 1440,
            function () use ($level) {
                return SecurityClearances::findBySlugOrFail($level);
            }
        );

        // Get Listings
        $listings = Cache::remember('levels_show_' . $level->slug . '_listings_' . $request->input('page', 1), 1440,
            function () use ($request, $level) {
                return $level->listings()->paginate(config('job-core.per_page'));
            }
        );

        // Sponsored Jobs
        $sponsored = Cache::remember('levels_show_' . $level->slug . '_sponsored', 1440,
            function () use ($level) {
                return $level->sponsoredListings();
            }
        );

        // Get Children
        $children = Cache::remember('levels_show_children', 1440,
            function () {
                return SecurityClearances::related()->get();
            }
        );

        return view('job-core::levels.show', compact('level', 'listings', 'sponsored', 'children'));
    }
}
