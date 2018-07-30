<?php

namespace Droplister\JobCore\App\Traits;

use Cache;
use Droplister\JobCore\App\Listing;

trait NarrowsListings
{
    /**
     * Narrow
     */
    public function scopeNarrow($query, $request)
    {
        $listings = Cache::remember('listings_narrowed_' . serialize($request->all()), 1440,
            function () use ($request) {
                return Listing::filter($request->all())->pluck('id');
            }
        );

        return $query->whereHas('listings',
            function ($listing) use ($listings) {
                $listing->whereIn('id', $listings);
            }
        )->take(config('job-core.max_relations'));
    }
}