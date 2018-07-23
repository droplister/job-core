<?php

namespace Droplister\JobCore\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoogleMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Locations
        $locations = \App\Location::map()->get();

        return Droplister\JobCore\App\Http\Resources\GoogleMapResource::collection($locations);
    }
}