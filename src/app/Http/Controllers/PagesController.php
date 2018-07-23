<?php


namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * About Page
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Advertise Page
     *
     * @return \Illuminate\Http\Response
     */
    public function advertise()
    {
        return view('pages.advertise');
    }

    /**
     * Disclaimer Page
     *
     * @return \Illuminate\Http\Response
     */
    public function disclaimer()
    {
        return view('pages.disclaimer');
    }

    /**
     * Privacy Page
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * Terms Page
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        return view('pages.terms');
    }
}
