<?php

namespace Droplister\JobCore\App;

use Cache;
use Droplister\JobCore\App\Traits\SponsoredListings;
use Znck\Eloquent\Traits\BelongsToThrough;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class OccupationalSeries extends Model
{
    use BelongsToThrough, Sluggable, SluggableScopeHelpers, SponsoredListings;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_family',
        'code',
        'value',
        'disabled',
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
        return Cache::rememberForever('career_' . $this->slug . '_page_title',
            function () {
                return $this->value . ' (' . $this->code . ') - ' . config('job-core.keyword');
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
        return Cache::remember('career_' . $this->slug . '_page_description', 1440,
            function () {               
                $listings_count = number_format($this->listings()->count());
                $keyword = strtolower(config('job-core.keyword'));

                return "Browse {$listings_count} {$this->value} career opportunities within the federal government, especially {$keyword}.";
            }
        );
    }

    /**
     * Parent Occupational Series
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(OccupationalSeries::class, 'job_family', 'code');
    }

    /**
     * Child Occupational Series
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(OccupationalSeries::class, 'job_family', 'code');
    }

    /**
     * Associated Security Clearances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clearances() {
        return $this->belongsToThrough(SecurityClearances::class, Listing::class, 'clearance_code', 'code', 'code');
    }

    /**
     * Occpational Series Listings
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'listing_occupational_series', 'occupational_series_id', 'listing_id')->listingsFilter();
    }

    /**
     * Home
     */
    public function scopeHome($query)
    {
        return $query->has('listings', '>=', config('job-core.min_listings'))
            ->where('value', 'not like', '%general%')
            ->where('value', 'not like', '%miscellaneous%')
            ->withCount('listings')
            ->orderBy('listings_count', 'desc')
            ->take(config('job-core.max_relations'));
    }

    /**
     * Index
     */
    public function scopeIndex($query)
    {
        return $query->has('listings', '>=', config('job-core.min_listings'))
            ->orderBy('job_family', 'asc')
            ->orderBy('value', 'asc');
    }

    /**
     * Related
     */
    public function scopeRelated($query, $career)
    {
        return $query->whereJobFamily($career->job_family)
            ->has('listings', '>=', config('job-core.min_listings'))
            ->orderBy('value', 'asc');
    }

    /**
     * Parents
     */
    public function scopeIsParent($query)
    {
        return $query->whereRaw('occupational_series.job_family = occupational_series.code');
    }

    /**
     * Children
     */
    public function scopeIsChild($query)
    {
        return $query->whereRaw('occupational_series.job_family != occupational_series.code');
    }

    /**
     * Enabled
     */
    public function scopeIsEnabled($query)
    {
        return $query->whereDisabled(0);
    }

    /**
     * By Family
     */
    public function scopeWhereHasFamily($query, $job_family)
    {
        return $query->where('job_family', $job_family);
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
