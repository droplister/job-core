<?php

namespace Droplister\JobCore\App;

use Droplister\JobCore\App\Traits\SponsoredListings;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class HiringPaths extends Model
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
        'disabled',
        'description',
    ];

    /**
     * Hiring Paths Listings
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'listing_hiring_path', 'hiring_path_id', 'listing_id')->listingFilter();
    }

    /**
     * Enabled
     */
    public function scopeIsEnabled($query)
    {
        return $query->whereDisabled(0);
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
        return $query->isEnabled()
            ->has('listings', '>=', config('job-core.min_listings'))
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