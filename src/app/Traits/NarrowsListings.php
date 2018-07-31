<?php

namespace Droplister\JobCore\App\Traits;

use Droplister\JobCore\App\Listing;

use Cache;

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
        )
        ->withCount('listings')
        ->orderBy('listings_count', 'desc')
        ->take(config('job-core.max_relations'));
    }
}