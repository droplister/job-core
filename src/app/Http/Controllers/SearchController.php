<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'sometimes|min:3',
            'l' => 'sometimes|exists:security_clearances,slug',
            's' => 'sometimes|exists:position_schedules,slug',
        ]);

        // Handle Search
        if($request->has('q'))
        {
            // Get Query
            $keyword = $request->q;

            // Get Subtitle
            $subtitle = 'Results for "' . title_case($keyword) . '"';

            // Get Listings
            $listings = Droplister\JobCore\App\Listing::search($keyword);

            // Handle Narrow
            if($request->has('l'))
            {
                // By Clearance
                $listings = $listings->narrow('clearances', $request->l);
            }

            // Handle Narrow
            if($request->has('s'))
            {
                // By Schedule
                $listings = $listings->narrow('schedule', $request->s);
            }

            // And Paginate
            $listings = $listings->paginate(config('job-core.per_page'));

            // Get Schedules
            $schedules = Droplister\JobCore\App\PositionSchedule::narrow($keyword)
                ->withCount('listings')
                ->orderBy('listings_count', 'desc')
                ->orderBy('value', 'asc')
                ->get();           

            // Get Levels
            $levels = Droplister\JobCore\App\SecurityClearances::narrow($keyword)->get(); 
        }
        else
        {
            $subtitle = null;
            $listings = null;
            $schedules = null;
            $locations = null;
        }

        return view('job-core::search.index', compact('request', 'subtitle', 'listings', 'schedules', 'levels'));
    }
}
