<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Droplister\JobCore\App\SecurityClearances;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SecurityClearancesController extends Controller
{
    /**
     * Security Clearance Index
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Clearances
        $clearances = Cache::remember('clearances_index', 1440,
            function () {
                return SecurityClearances::index()->get();
            }
        );

        return view('job-core::clearances.index', compact('clearances'));
    }

    /**
     * Show Security Clearance
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $clearance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $clearance)
    {
        // Get Clearance
        $clearance = Cache::remember('clearances_show_' . $clearance, 1440,
            function () use ($clearance) {
                return SecurityClearances::findBySlugOrFail($clearance);
            }
        );

        // Get Listings
        $listings = Cache::remember('clearances_show_' . $clearance->slug . '_listings_' . $request->input('page', 1), 1440,
            function () use ($request, $clearance) {
                return $clearance->listings()->paginate(config('job-core.per_page'));
            }
        );

        // Sponsored Jobs
        $sponsored = Cache::remember('clearances_show_' . $clearance->slug . '_sponsored', 1440,
            function () use ($clearance) {
                return $clearance->sponsoredListings();
            }
        );

        // Get Children
        $children = Cache::remember('clearances_show_children', 1440,
            function () {
                return SecurityClearances::related()->get();
            }
        );

        return view('job-core::clearances.show', compact('clearance', 'listings', 'sponsored', 'children'));
    }
}
