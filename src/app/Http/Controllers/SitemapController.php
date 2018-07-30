<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\Location;
use Droplister\JobCore\App\PayPlans;
use Droplister\JobCore\App\HiringPaths;
use Droplister\JobCore\App\PositionSchedule;
use Droplister\JobCore\App\TravelPercentage;
use Droplister\JobCore\App\AgencySubElements;
use Droplister\JobCore\App\OccupationalSeries;
use Droplister\JobCore\App\SecurityClearances;

class SitemapController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $routes = [
            'home.index',
            'search.index',
            'agencies.index',
            'listings.index',
            'clearances.index',
            'careers.index',
            'locations.index',
            'plans.index',
            'schedules.index',
            'travels.index',
            'paths.index',
            'most.index',
            'specific.index',
            'contact.create',
            'pages.about',
            'pages.advertise',
            'pages.disclaimer',
            'pages.newsletter',
            'pages.privacy',
            'pages.terms'
        ];

        // Get Agencies
        $agencies = Cache::remember('sitemap_agencies', 1440,
            function () {
				return AgencySubElements::relatedFilter()->get();
            }
        );

        // Get Hiring Paths
        $paths = Cache::remember('sitemap_paths', 1440,
            function () {
				return HiringPaths::index()->get();
            }
        );

        // Get Locations
        $locations = Cache::remember('sitemap_locations', 1440,
            function () {
				return Location::relatedFilter()->get();
            }
        );

        // Get Careers
        $careers = Cache::remember('sitemap_career', 1440,
            function () {
				return OccupationalSeries::index()->get();
            }
        );

        // Get Pay Plans
        $plans = Cache::remember('sitemap_plans', 1440,
            function () {
				return PayPlans::index()->get();
            }
        );

        // Get Position Schedules
        $schedules = Cache::remember('sitemap_schedules', 1440,
            function () {
				return PositionSchedule::index()->get();
            }
        );

        // Get Security Clearances
        $clearances = Cache::remember('sitemap_clearances', 1440,
            function () {
				return SecurityClearances::index()->get();
            }
        );

        // Get Travel Percentages
        $travels = Cache::remember('sitemap_travels', 1440,
            function () {
				return TravelPercentage::index()->get();
            }
        );

        // Get Listings
        $listings = Cache::remember('sitemap_listings', 1440,
            function () {
				return Listing::listingsFilter()->get();
            }
        );

        return view('job-core::sitemap.index', compact('agencies', 'paths', 'locations', 'careers', 'plans', 'schedules', 'clearances', 'travels', 'listings'));
    }
}