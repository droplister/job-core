<?php


namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * About Page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function about(Request $request)
    {
        return view('job-core::pages.about');
    }

    /**
     * Advertise Page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function advertise(Request $request)
    {
        return view('job-core::pages.advertise');
    }

    /**
     * Disclaimer Page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disclaimer(Request $request)
    {
        return view('job-core::pages.disclaimer');
    }

    /**
     * Newsletter Page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newsletter(Request $request)
    {
        return view('job-core::pages.newsletter');
    }

    /**
     * Privacy Page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function privacy(Request $request)
    {
        return view('job-core::pages.privacy');
    }

    /**
     * Terms Page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function terms(Request $request)
    {
        return view('job-core::pages.terms');
    }
}
