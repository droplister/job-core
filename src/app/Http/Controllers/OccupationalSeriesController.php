<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\OccupationalSeries;

class OccupationalSeriesController extends Controller
{
    /**
     * Occupational Series Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Careers
        $careers = Cache::remember('careers_index', 1440,
            function () {
                return OccupationalSeries::index()->get();
            }
        );

        // Get Chunks
        $chunks = Cache::remember('careers_index_chunks', 1440,
            function () use ($careers) {
                $chunk_size = ceil(count($careers->groupBy('job_family')) / 3);

                return $careers->groupBy('job_family')->chunk($chunk_size);
            }
        );

        return view('job-core::careers.index', compact('careers', 'chunks'));
    }

    /**
     * Show Occupational Series
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $career)
    {
        // Get Career
        $career = Cache::remember('careers_show_' . $career, 1440,
            function () use ($career) {
                return OccupationalSeries::findBySlugOrFail($career);
            }
        );

        // Get Listings
        $listings = Cache::remember('careers_show_' . $career->slug . '_listings_' . $request->input('page', 1), 1440,
            function () use ($request, $career) {
                return $career->listings()->paginate(config('job-core.per_page'));
            }
        );

        // Sponsored Jobs
        $sponsored = Cache::remember('careers_show_' . $career->slug . '_sponsored', 1440,
            function () use ($career) {
                return $career->sponsoredListings();
            }
        );

        // Get Parent
        $parent = Cache::remember('careers_show_' . $career->slug . '_parent', 1440,
            function () use ($career) {
                return $career->parent;
            }
        );

        // Get Children
        $children = Cache::remember('careers_show_' . $career->slug . '_children', 1440,
            function () use ($career) {
                return OccupationalSeries::related($career)->get();
            }
        );

        return view('job-core::careers.show', compact('career', 'listings', 'sponsored', 'parent', 'children'));
    }
}
