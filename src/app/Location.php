<?php

namespace Droplister\JobCore\App;

use Droplister\JobCore\App\Traits\NarrowsListings;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use NarrowsListings, Sluggable, SluggableScopeHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'type',
        'name',
        'title',
        'description',
        'longitude',
        'latitude',
    ];

    /**
     * Parent Location
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    /**
     * Child Locations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    /**
     * Listings
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class)->listingFilter();
    }

    /**
     * Related Locations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function related()
    {
        return $this->hasMany(Location::class, 'parent_id')->relatedFilter();
    }

    /**
     * Home
     */
    public function scopeHome($query)
    {
        return $query->isCity()
            ->has('listings', '>=', config('job-core.min_listings'))
            ->withCount('listings')
            ->orderBy('listings_count', 'desc')
            ->take(config('job-core.max_relations'));
    }

    /**
     * Index
     */
    public function scopeIndex($query)
    {
        switch(config('job-core.filter'))
        {
            case 'military_base': 
                return $query->isState()
                    ->has('listings', '>=', config('job-core.min_listings'))
                    ->where('name', 'not like', '% County')
                    ->orderBy('title', 'asc');
            default:
                return $query->isState()
                    ->relatedFilter();
        }
    }

    /**
     * Related Searches
     */
    public function scopeRelatedFilter($query)
    {
        switch(config('job-core.filter'))
        {
            case 'military_base': 
                return $query->isMilitaryBase()
                    ->has('listings', '>=', config('job-core.min_listings'))
                    ->where('name', 'not like', '% County')
                    ->orderBy('title', 'asc');
            default:
                return $query->has('listings', '>=', config('job-core.min_listings'))
                    ->where('name', 'not like', '% County')
                    ->orderBy('title', 'asc');
        }
    }

    /**
     * Map
     */
    public function scopeMap($query)
    {
        return $query->whereNotNull('latitude')
            ->withCount('listings')
            ->relatedFilter();
    }

    /**
     * Countries
     */
    public function scopeIsCountry($query)
    {
        return $query->whereType('country');
    }

    /**
     * States
     */
    public function scopeIsState($query)
    {
        return $query->whereType('state');
    }

    /**
     * Cities
     */
    public function scopeIsCity($query)
    {
        return $query->whereType('city')->where('name', 'not like', '% County');
    }

    /**
     * Military Base
     */
    public function scopeIsMilitaryBase($query)
    {
        return $query->where('name', 'like', 'Military %')
            ->orWhere('name', 'like', 'Fort %')
            ->orWhere('name', 'like', 'Camp %')
            ->orWhere('name', 'like', 'Air %')
            ->orWhere('name', 'like', 'Army %')
            ->orWhere('name', 'like', 'Pentagon, %')
            ->orWhere('name', 'like', 'Navy %')
            ->orWhere('name', 'like', 'Army %')
            ->orWhere('name', 'like', 'Joint %')
            ->orWhere('name', 'like', 'Marine Corps Air Station %')
            ->orWhere('name', 'like', '% Military %')
            ->orWhere('name', 'like', '% Army %')
            ->orWhere('name', 'like', '% Navy %')
            ->orWhere('name', 'like', '% Naval %')
            ->orWhere('name', 'like', '% AFB')
            ->orWhere('name', 'like', '% ANG')
            ->orWhere('name', 'like', '% Air Reserve Base')
            ->orWhere('name', 'like', '% Airfield')
            ->orWhere('name', 'like', '% Arsenal')
            ->orWhere('name', 'like', '% Barracks')
            ->orWhere('name', 'like', '% Base')
            ->orWhere('name', 'like', '% Defense Logistics Center')
            ->orWhere('name', 'like', '% Field')
            ->orWhere('name', 'like', '% Missile Range')
            ->orWhere('name', 'like', '% Ordnance Depot')
            ->orWhere('name', 'like', '% Proving Ground')
            ->orWhere('name', 'like', '% Submarine Base')
            ->orWhere('name', 'like', 'Twentynine Palms');
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
                'source' => 'title',
            ]
        ];
    }
}