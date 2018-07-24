<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OccupationalSeriesController extends Controller
{
    /**
     * Occupational Series Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Careers
        $careers = \Droplister\JobCore\App\OccupationalSeries::index()->get();

        // Chunk Size
        $chunk_size = ceil(count($careers->groupBy('job_family')) / 3);

        // Get Chunks
        $chunks = $careers->groupBy('job_family')->chunk($chunk_size);

        return view('job-core::careers.index', compact('careers', 'chunks'));
    }

    /**
     * Show Occupational Series
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $career)
    {
        // Get Career
        $career = \Droplister\JobCore\App\OccupationalSeries::findBySlugOrFail($career);
        
        // Get Listings
        $listings = $career->listings()->paginate(config('job-core.per_page'));

        // Get Parent
        $parent = $career->parent;

        // Get Children
        $children = \Droplister\JobCore\App\OccupationalSeries::related($career)->get();

        return view('job-core::careers.show', compact('career', 'listings', 'parent', 'children'));
    }
}
