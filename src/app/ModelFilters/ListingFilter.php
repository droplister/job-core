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

    public function q($keyword)
    {
        return $this->where('position_title', 'like', '%' . $keyword . '%')
            ->orWhere('job_summary', 'like', '%' . $keyword . '%');
    }

    public function agency($id)
    {
        $this->related('agencies', 'id', $id);
    }

    public function path($id)
    {
        $this->related('hiringPaths', 'id', $id);
    }

    public function location($id)
    {
        $this->related('locations', 'id', $id);
    }

    public function career($id)
    {
        $this->related('careers', 'id', $id);
    }

    public function plan($id)
    {
        $this->related('payPlans', 'id', $id);
    }

    public function clearance($id)
    {
        $this->related('securityClearances', 'id', $id);
    }

    public function schedule($code)
    {
        return $this->where('position_schedule_code', $code);
    }

    public function travel($code)
    {
        return $this->where('travel_percentage_code', '=', $code);
    }

    public function setup()
    {
        $this->listingsFilter();
    }
}
