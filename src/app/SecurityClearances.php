<?php

namespace Droplister\JobCore\App;

use Cache;
use Droplister\JobCore\App\Traits\NarrowsListings;
use Droplister\JobCore\App\Traits\SponsoredListings;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class SecurityClearances extends Model
{
    use NarrowsListings, Sluggable, SluggableScopeHelpers, SponsoredListings;

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
        return Cache::rememberForever('level_' . $this->slug . '_page_title',
            function () {
                return $this->value . ' ' . config('job-core.keyword');
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
        return Cache::remember('level_' . $this->slug . '_page_description', 1440,
            function () {               
                $listings_count = number_format($this->listings()->count());
                $keyword = strtolower(config('job-core.keyword'));

                return "Search from the {$listings_count} {$keyword} that require {$this->value} security clearance as a basic qualification for government employment.";
            }
        );
    }

    /**
     * Securty Clearance Careers
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function careers()
    {
        return $this->hasManyThrough(OccupationalSeries::class, Listing::class, 'clearance_code', 'code', 'code');
    }

    /**
     * Job Listings
     *  
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'listing_security_clearance', 'security_clearance_id', 'listing_id')->listingsFilter();
    }

    /**
     * Job Listings (inactive)
     *  
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inactiveListings()
    {
        return $this->belongsToMany(Listing::class, 'listing_security_clearance', 'security_clearance_id', 'listing_id')->listingsFilter(false);
    }

    /**
     * Home
     */
    public function scopeHome($query)
    {
        return $query->index()
            ->take(config('job-core.max_relations'));
    }

    /**
     * Index
     */
    public function scopeIndex($query)
    {
        return $query->cleared()
            ->has('listings')
            ->orderBy('code', 'asc');
    }

    /**
     * Related
     */
    public function scopeRelated($query)
    {
        return $query->index();
    }

    /**
     * Cleared
     */
    public function scopeCleared($query)
    {
        return $query->whereIn('code', [1, 2, 3, 4, 5, 6, 7]);
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
