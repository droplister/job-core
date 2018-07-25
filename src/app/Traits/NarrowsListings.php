<?php

namespace Droplister\JobCore\App\Traits;

use Droplister\JobCore\App\Listing;

trait NarrowsListings
{
    /**
     * Narrow
     */
    public function scopeNarrow($query, $keyword)
    {
        $listings = Listing::search($keyword)->pluck('id');

        return $query->whereHas('listings',
            function ($listing) use ($listings) {
                $listing->whereIn('id', $listings);
            }
        )->take(config('job-core.max_relations'));
    }
}