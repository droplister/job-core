<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AffiliateController extends Controller
{
    /**
     * Affiliate Link
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect(config('job-core.affiliate_url'));
    }
}