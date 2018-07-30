<?php

namespace Droplister\JobCore\App;

use Cache;
use Droplister\JobCore\App\Traits\NarrowsListings;
use Droplister\JobCore\App\Traits\ChunksParagraphs;
use Droplister\JobCore\App\Traits\SponsoredListings;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use ChunksParagraphs, NarrowsListings, Sluggable, SluggableScopeHelpers, SponsoredListings;

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
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'pageTitle',
        'pageDescription',
    ];

    /**
     * Page Title
     *
     * @return string
     */
    public function getPageTitleAttribute()
    {
        return Cache::rememberForever('location_' . $this->slug . '_page_title',
            function () {               
                return config('job-core.keyword') . ' in ' . $this->title;
            }
        );
    }
    
    /**
     * Page Description
     *
     * @return string
     */
    public function getPageDescriptionAttribute()
    {
        return Cache::remember('location_' . $this->slug . '_page_description', 1440,
            function () {
                $listings_count = number_format($this->listings()->count());
                $children = $this->related()->paginate(3);

                if($this->type === 'state' && $children->total() > 2)
                {
                    foreach($children as $child)
                    {
                        $name = explode(', ', $child->name);
                        $cities[] = $name[0];
                    }

                    $description = "including opportunities in {$cities[0]}, {$cities[1]}, and {$cities[2]}";

                    return "Search {$listings_count} {$this->pageTitle}, {$description}.";
                }

                $description = "Find a full or part-time role with a federal agency in {$this->name}";

                return "Search {$listings_count} {$this->pageTitle}. {$description}.";
            }
        );
    }

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
     * Jon Listings
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class)->listingsFilter();
    }

    /**
     * Job Listings (inactive)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inactiveListings()
    {
        return $this->belongsToMany(Listing::class)->listingsFilter(false);
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
        switch(config('job-core.filter'))
        {
            case 'federal': 
                return $query->isCity()
                    ->notMilitaryBase()
                    ->has('listings', '>=', config('job-core.min_listings'))
                    ->withCount('listings')
                    ->orderBy('listings_count', 'desc')
                    ->take(config('job-core.max_relations'));
            default:
                return $query->isCity()
                    ->has('listings', '>=', config('job-core.min_listings'))
                    ->withCount('listings')
                    ->orderBy('listings_count', 'desc')
                    ->take(config('job-core.max_relations'));
        }
    }

    /**
     * Index
     */
    public function scopeIndex($query)
    {
        switch(config('job-core.filter'))
        {
            case 'federal': 
                return $query->isState()
                    ->has('listings', '>=', config('job-core.min_listings'))
                    ->where('name', 'not like', '% County')
                    ->orderBy('title', 'asc');
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
            case 'federal': 
                return $query->notMilitaryBase()
                    ->has('listings', '>=', config('job-core.min_listings'))
                    ->where('name', 'not like', '% County')
                    ->orderBy('title', 'asc');
            case 'military_base': 
                return $query->isMilitaryBase()
                    ->militaryBaseEdgeCase()
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
            ->orWhere('name', 'like', '% Air Force %')
            ->orWhere('name', 'like', '% Army %')
            ->orWhere('name', 'like', '% Navy %')
            ->orWhere('name', 'like', '% Naval %')
            ->orWhere('name', 'like', '% AFB')
            ->orWhere('name', 'like', '% AFS')
            ->orWhere('name', 'like', '% ANG')
            ->orWhere('name', 'like', '% Air Reserve Base')
            ->orWhere('name', 'like', '% Airfield')
            ->orWhere('name', 'like', '% Arsenal')
            ->orWhere('name', 'like', '% Barracks')
            ->orWhere('name', 'like', '% Base')
            ->orWhere('name', 'like', '% Center')
            ->orWhere('name', 'like', '% Defense Logistics Center')
            ->orWhere('name', 'like', '% Field')
            ->orWhere('name', 'like', '% Missile Range')
            ->orWhere('name', 'like', '% Ordnance Depot')
            ->orWhere('name', 'like', '% Proving Ground')
            ->orWhere('name', 'like', '% Submarine Base')
            ->orWhere('name', 'like', 'Pearl Harbor')
            ->orWhere('name', 'like', 'Twentynine Palms');
    }

    /**
     * Not Military Base
     */
    public function scopeNotMilitaryBase($query)
    {
        return $query->where('name', 'not like', 'Military %')
            ->where('name', 'not like', 'Fort %')
            ->where('name', 'not like', 'Camp %')
            ->where('name', 'not like', 'Air %')
            ->where('name', 'not like', 'Army %')
            ->where('name', 'not like', 'Naval %')
            ->where('name', 'not like', 'Pentagon, %')
            ->where('name', 'not like', 'Navy %')
            ->where('name', 'not like', 'Army %')
            ->where('name', 'not like', 'Joint %')
            ->where('name', 'not like', 'Marine Corps Air Station %')
            ->where('name', 'not like', '% Military %')
            ->where('name', 'not like', '% Air Force %')
            ->where('name', 'not like', '% Army %')
            ->where('name', 'not like', '% Navy %')
            ->where('name', 'not like', '% Naval %')
            ->where('name', 'not like', '% Defense Logistics Center %')
            ->where('name', 'not like', '% AFB')
            ->where('name', 'not like', '% AFS')
            ->where('name', 'not like', '% ANG')
            ->where('name', 'not like', '% Air Reserve Base')
            ->where('name', 'not like', '% Airfield')
            ->where('name', 'not like', '% Arsenal')
            ->where('name', 'not like', '% Barracks')
            ->where('name', 'not like', '% Base')
            ->where('name', 'not like', '% Center')
            ->where('name', 'not like', '% Defense Logistics Center')
            ->where('name', 'not like', '% Field')
            ->where('name', 'not like', '% Missile Range')
            ->where('name', 'not like', '% Ordnance Depot')
            ->where('name', 'not like', '% Proving Ground')
            ->where('name', 'not like', '% Submarine Base')
            ->where('name', 'not like', 'Twentynine Palms');
    }

    /**
     * Military Base Edge Case
     */
    public function scopeMilitaryBaseEdgeCase($query)
    {
        return $query->where('name', '!=', 'Fort Defiance')
            ->where('name', '!=', 'Fort Smith')
            ->where('name', '!=', 'Fort Collins')
            ->where('name', '!=', 'Fort Morgan')
            ->where('name', '!=', 'Fort Lauderdale')
            ->where('name', '!=', 'Fort Myers')
            ->where('name', '!=', 'Fort Wayne')
            ->where('name', '!=', 'Fort Dodge')
            ->where('name', '!=', 'Fort Washington')
            ->where('name', '!=', 'Fort Benton')
            ->where('name', '!=', 'Fort Peck')
            ->where('name', '!=', 'Fort Yates')
            ->where('name', '!=', 'Fort Thompson')
            ->where('name', '!=', 'Fort Stockton')
            ->where('name', '!=', 'Fort Worth')
            ->where('name', '!=', 'Fort Duchesne')
            ->where('name', '!=', 'Fort Washakie')
            ->where('name', '!=', 'Camp Douglas')
            ->where('name', '!=', 'Camp Hill')
            ->where('name', '!=', 'Clay Center');
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