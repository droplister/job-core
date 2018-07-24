<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Top Locations
        $locations = \Cache::remember('home_locations', 1440, function () {
            return \Droplister\JobCore\App\Location::home()->get();
        });

        // Top Careers
        $careers = \Cache::remember('home_careers', 1440, function () {
            return \Droplister\JobCore\App\OccupationalSeries::home()->get();
        });

        // Top Agencies
        $agencies = \Cache::remember('home_agencies', 1440, function () {
            return \Droplister\JobCore\App\AgencySubElements::home()->get();
        });

        // Top Levels
        $levels = \Cache::remember('home_levels', 1440, function () {
            return \Droplister\JobCore\App\SecurityClearances::home()->get();
        });

        return view('home', compact('locations', 'careers', 'agencies', 'levels'));
    }
}