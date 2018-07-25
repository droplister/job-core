<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Contact Create
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('job-core::contact.create');
    }

    /**
     * Handle Contact
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//
    }
}
