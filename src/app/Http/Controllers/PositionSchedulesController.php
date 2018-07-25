<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\PositionSchedule;

class PositionSchedulesController extends Controller
{
     /**
     * Schedules Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Schedules
        $schedules = Cache::remember('schedules_index', 1440,
            function () {
                return PositionSchedule::index()->get();
            }
        );

        return view('job-core::schedules.index', compact('schedules'));
    }

    /**
     * Show Schedule
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $schedule)
    {
        // Get Schedule
        $schedule = Cache::remember('schedules_show_' . $schedule, 1440,
            function () use ($schedule) {
                return PositionSchedule::findBySlugOrFail($schedule);
            }
        );

        // Get Listings
        $listings = Cache::remember('schedules_show_' . $schedule->slug . '_listings_' . $request->input('page', 1), 1440,
            function () use ($request, $schedule) {
                return $schedule->listings()->paginate(config('job-core.per_page'));
            }
        );

        // Sponsored Jobs
        $sponsored = Cache::remember('schedules_show_' . $schedule->slug . '_sponsored', 1440,
            function () use ($schedule) {
                return $schedule->sponsoredListings();
            }
        );

        // Get Children
        $children = Cache::remember('schedules_show_children', 1440,
            function () {
                return PositionSchedule::related()->get();
            }
        );

        return view('job-core::schedules.show', compact('schedule', 'listings', 'sponsored', 'children'));
    }
}