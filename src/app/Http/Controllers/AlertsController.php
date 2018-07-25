<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlertsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Alerts Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $alerts = [];

    	return view('job-core::alerts.index', compact('user', 'alerts'));
    }

    /**
     * Alerts Show
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    	return view('job-core::alerts.show');
    }

    /**
     * Alerts Create
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('job-core::alerts.create');
    }
}
