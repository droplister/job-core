<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayPlansController extends Controller
{
    /**
     * Pay Plan Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Pay Plans
        $plans = Droplister\JobCore\App\PayPlans::index()->get();

        // Get Chunks
        $chunks = null;

        return view('job-core::plans.index', compact('plans', 'chunks'));
    }

    /**
     * Show Pay Plan
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $plan)
    {
        // Get Pay Plan
        $plan = Droplister\JobCore\App\PayPlans::findBySlugOrFail($plan);

        // Get Listings
        $listings = $plan->listings()->paginate(config('job-core.per_page'));

        // Get Parent
        $parent = null;

        // Get Children
        $children = Droplister\JobCore\App\PayPlans::related()->get();

        return view('job-core::plans.show', compact('plan', 'listings', 'parent', 'children'));
    }
}