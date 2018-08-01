<?php

namespace Droplister\JobCore\App\ModelFilters;

use Carbon\Carbon;

use EloquentFilter\ModelFilter;

class ListingFilter extends ModelFilter
{
    public function q($keyword)
    {
        return $this->where('position_title', 'like', '%' . $keyword . '%')
            ->orWhere('job_summary', 'like', '%' . $keyword . '%')
            ->orWhere('qualification_summary', 'like', '%' . $keyword . '%')
            ->orWhere('job_grade_code', 'like', '%' . $keyword . '%')
            ->orWhere('position_location_display', 'like', '%' . $keyword . '%');
    }

    public function days_ago($days)
    {
        return $this->where('publication_start_date', '>', Carbon::now()->subDays($days));
    }

    public function agency($slug)
    {
        return $this->related('agencies', 'slug', $slug);
    }

    public function path($slug)
    {
        return $this->related('hiringPaths', 'slug', $slug);
    }

    public function location($slug)
    {
        return $this->related('locations', 'slug', $slug);
    }

    public function career($slug)
    {
        return $this->related('careers', 'slug', $slug);
    }

    public function plan($slug)
    {
        return $this->related('payPlans', 'slug', $slug);
    }

    public function clearance($slug)
    {
        return $this->related('securityClearances', 'slug', $slug);
    }

    public function schedule($slug)
    {
        return $this->related('positionSchedule', 'slug', $slug);
    }

    public function travel($slug)
    {
        return $this->related('travelPercentage', 'slug', $slug);
    }

    public function job_grade($code)
    {
        return $this->where('job_grade_code', $code);
    }

    public function low_grade($grade)
    {
        return $this->where('low_grade', '>=', $grade);
    }

    public function high_grade($grade)
    {
        return $this->where('high_grade', '<=', $grade);
    }

    public function setup()
    {
        return $this->listingsFilter();
    }
}
