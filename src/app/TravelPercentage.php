<?php

namespace Droplister\JobCore\App;

use Droplister\JobCore\App\Traits\SponsoredListings;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class TravelPercentage extends Model
{
    use Sluggable, SluggableScopeHelpers, SponsoredListings;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'value',
        'description',
    ];

    /**
     * Job Listings
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->hasMany(Listing::class, 'travel_percentage_code', 'code')->listingsFilter();
    }

    /**
     * Job Listings (inactive)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inactiveListings()
    {
        return $this->hasMany(Listing::class, 'travel_percentage_code', 'code')->listingsFilter(false);
    }

    /**
     * Home
     */
    public function scopeHome($query)
    {
        return $query->index();
    }

    /**
     * Index
     */
    public function scopeIndex($query)
    {
        return $query->has('listings', '>=', config('job-core.min_listings'))
            ->withCount('listings')
            ->orderBy('value', 'asc');
    }

    /**
     * Related
     */
    public function scopeRelated($query)
    {
        return $query->index();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'value',
            ]
        ];
    }
}
