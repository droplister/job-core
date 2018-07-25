<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\PayPlans;

class PayPlansController extends Controller
{
    /**
     * Pay Plan Index
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Pay Plans
        $plans = Cache::remember('plans_index', 1440,
            function () {
                return PayPlans::index()->get();
            }
        );

        return view('job-core::plans.index', compact('plans'));
    }

    /**
     * Show Pay Plan
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $plan)
    {
        // Get Pay Plan
        $plan = Cache::remember('plans_show_' . $plan, 1440,
            function () use ($plan) {
                return PayPlans::findBySlugOrFail($plan);
            }
        );

        // Get Listings
        $listings = Cache::remember('plans_show_' . $plan->slug . '_listings_' . $request->input('page', 1), 1440,
            function () use ($request, $plan) {
                return $plan->listings()->paginate(config('job-core.per_page'));
            }
        );

        // Sponsored Jobs
        $sponsored = Cache::remember('plans_show_' . $plan->slug . '_sponsored', 1440,
            function () use ($plan) {
                return $plan->sponsoredListings();
            }
        );

        // Get Children
        $children = Cache::remember('plans_show_children', 1440,
            function () {
                return PayPlans::related()->get();
            }
        );

        return view('job-core::plans.show', compact('plan', 'listings', 'sponsored', 'children'));
    }
}