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
            'careers.index',
            'locations.index',
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

        // Get Listings
        $listings = Cache::remember('sitemap_listings', 1440,
            function () {
                return Listing::listingsFilter()->get();
            }
        );

        $view = view('job-core::sitemap.index', compact('routes', 'agencies', 'locations', 'careers', 'listings'));

        return response($view, 200)
            ->header('Content-Type', 'text/xml');
    }
}