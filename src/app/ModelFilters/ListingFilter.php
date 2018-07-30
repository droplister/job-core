<?php

namespace Droplister\JobCore\App\ModelFilters;

use EloquentFilter\ModelFilter;

class ListingFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function setup($query)
    {
        return $query->listingsFilter();
    }

    public function q($keyword)
    {
	    $this->whereLike($keyword);
    }

    public function agency($id)
    {
	    $this->related('agencies', function($query) use ($id) {
	        return $query->where('id', $id);
	    });
    }

    public function path($id)
    {
	    $this->related('hiringPaths', function($query) use ($id) {
	        return $query->where('id', $id);
	    });
    }

    public function location($id)
    {
	    $this->related('locations', function($query) use ($id) {
	        return $query->where('id', $id);
	    });
    }

    public function career($id)
    {
	    $this->related('careers', function($query) use ($id) {
	        return $query->where('id', $id);
	    });
    }

    public function plan($id)
    {
	    $this->related('payPlans', function($query) use ($id) {
	        return $query->where('id', $id);
	    });
    }

    public function clearance($id)
    {
	    $this->related('securityClearances', function($query) use ($id) {
	        return $query->where('id', $id);
	    });
    }

    public function schedule($code)
    {
	    return $this->where('position_schedule_code', $code);
    }

    public function travel($code)
    {
	    return $this->where('travel_percentage_code', '=', $code);
    }
}
