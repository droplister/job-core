<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SecurityClearancesController extends Controller
{
    /**
     * Security Clearance Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Levels
        $levels = \Droplister\JobCore\App\SecurityClearances::index()->get();

        // Get Chunks
        $chunks = null;

        return view('levels.index', compact('levels', 'chunks'));
    }

    /**
     * Show Security Clearance
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $level)
    {
        // Get Level
        $level = \Droplister\JobCore\App\SecurityClearances::findBySlugOrFail($level);
        
        //  Get Listings
        $listings = $level->listings()->paginate(config('job-core.per_page'));

        // Get Parent
        $parent = null;

        // Get Children
        $children = \Droplister\JobCore\App\SecurityClearances::related()->get();

        return view('levels.show', compact('level', 'listings', 'parent', 'children'));
    }
}
