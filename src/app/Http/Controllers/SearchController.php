<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\PositionSchedule;
use Droplister\JobCore\App\SecurityClearances;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
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
            $listings = Listing::search($keyword);

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
            $schedules = PositionSchedule::narrow($keyword)
                ->withCount('listings')
                ->orderBy('listings_count', 'desc')
                ->orderBy('value', 'asc')
                ->get();           

            // Get Levels
            $levels = SecurityClearances::narrow($keyword)->get(); 
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
