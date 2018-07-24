<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionSchedulesController extends Controller
{
     /**
     * Schedules Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Schedules
        $schedules = Droplister\JobCore\App\PositionSchedule::index()->get();

        // Get Chunks
        $chunks = null;

        return view('job-core::schedules.index', compact('schedules', 'chunks'));
    }

    /**
     * Show Schedule
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $schedule)
    {
        // Get Schedule
        $schedule = Droplister\JobCore\App\PositionSchedule::findBySlugOrFail($schedule);

        // Get Listings
        $listings = $schedule->listings()->paginate(config('job-core.per_page'));

        // Get Parent
        $parent = null;

        // Get Children
        $children = Droplister\JobCore\App\PositionSchedule::related()->get();

        return view('job-core::schedules.show', compact('schedule', 'listings', 'parent', 'children'));
    }
}