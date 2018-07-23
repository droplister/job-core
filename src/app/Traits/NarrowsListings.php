<?php

namespace Droplister\JobCore\App\Traits;

trait NarrowsListings
{
    /**
     * Narrow
     */
    public function scopeNarrow($query, $keyword)
    {
        $listings = \App\Listing::search($keyword)->pluck('id');

        return $query->whereHas('listings', function($listing) use($listings) {
                $listing->whereIn('id', $listings);
            })->take(config('job-core.max_relations'));
    }
}