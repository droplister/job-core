<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Location;
use Droplister\JobCore\App\AgencySubElements;
use Droplister\JobCore\App\OccupationalSeries;
use Droplister\JobCore\App\SecurityClearances;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Top Locations
        $locations = Cache::remember('home_locations', 1440,
            function () {
                return Location::home()->get();
            }
        );

        // Top Careers
        $careers = Cache::remember('home_careers', 1440,
            function () {
                return OccupationalSeries::home()->get();
            }
        );

        // Top Agencies
        $agencies = Cache::remember('home_agencies', 1440,
            function () {
                return AgencySubElements::home()->get();
            }
        );

        // Top Levels
        $levels = Cache::remember('home_levels', 1440,
            function () {
                return SecurityClearances::home()->get();
            }
        );

        return view('job-core::home', compact('locations', 'careers', 'agencies', 'levels'));
    }
}