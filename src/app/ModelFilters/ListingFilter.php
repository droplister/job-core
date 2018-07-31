<?php

namespace Droplister\JobCore\App\ModelFilters;

use EloquentFilter\ModelFilter;

class ListingFilter extends ModelFilter
{
    public function q($keyword)
    {
        return $this->where('position_title', 'like', '%' . $keyword . '%')
            ->orWhere('job_summary', 'like', '%' . $keyword . '%')
            ->orWhere('qualification_summary', 'like', '%' . $keyword . '%');
    }

    public function agency($slug)
    {
        $this->related('agencies', 'slug', $slug);
    }

    public function path($slug)
    {
        $this->related('hiringPaths', 'slug', $slug);
    }

    public function location($slug)
    {
        $this->related('locations', 'slug', $slug);
    }

    public function career($slug)
    {
        $this->related('careers', 'slug', $slug);
    }

    public function plan($slug)
    {
        $this->related('payPlans', 'slug', $slug);
    }

    public function clearance($slug)
    {
        $this->related('securityClearances', 'slug', $slug);
    }

    public function schedule($slug)
    {
        $this->related('positionSchedule', 'slug', $slug);
    }

    public function travel($slug)
    {
        $this->related('travelPercentage', 'slug', $slug);
    }

    public function job_grade($code)
    {
        $this->where('job_grade_code', $code);
    }

    public function low_grade($grade)
    {
        $this->where('low_grade', '>=', $grade);
    }

    public function high_grade($grade)
    {
        $this->where('high_grade', '<=', $grade);
    }

    public function setup()
    {
        $this->listingsFilter();
    }
}
