<?php

namespace Droplister\JobCore\App\Http\Controllers\Api;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Droplister\JobCore\App\Location;
use Droplister\JobCore\App\Http\Resources\GoogleMapResource;

class GoogleMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Locations
        $locations = Cache::remember('google_map_index', 1440,
            function () {
                return Location::map()->get();
            }
        );

        return GoogleMapResource::collection($locations);
    }
}