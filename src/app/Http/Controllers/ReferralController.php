<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\Mail\ReferralEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class ReferralController extends Controller
{
    /**
     * Referral Create
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('job-core::referral.create');
    }

    /**
     * Handle Referral
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'from' => 'required|email',
            'listing' => 'required|exists:listings,slug',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $listing = Listing::findBySlug($request->listing);

        Mail::to($request->to)->send(new ReferralEmail($request->from, $listing));

        return redirect(route('referral.create'))->with('success', 'Email Sent');
    }
}