<?php

namespace Droplister\JobCore\App;

use Droplister\JobCore\App\Traits\ChunksParagraphs;
use Droplister\JobCore\App\Traits\SponsoredListings;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class AgencySubElements extends Model
{
    use ChunksParagraphs, Sluggable, SluggableScopeHelpers, SponsoredListings;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_code',
        'code',
        'value',
        'description',
        'url',
        'logo_url',
        'disabled',
    ];

    /**
     * Child Agencies
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(AgencySubElements::class, 'parent_code', 'code');
    }

    /**
     * Parent Agency
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(AgencySubElements::class, 'parent_code', 'code');
    }

    /**
     * Job Listings (Cleared)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'listing_agency_sub_element', 'agency_sub_element_id', 'listing_id')->listingFilter();
    }

    /**
     * Related Agencies
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function related()
    {
        return $this->hasMany(AgencySubElements::class, 'parent_code', 'code')->relatedFilter();
    }

    /**
     * Home
     */
    public function scopeHome($query)
    {
        return $query->withCount('listings')
            ->orderBy('listings_count', 'desc')
            ->relatedFilter()
            ->take(config('job-core.max_relations'));
    }

    /**
     * Index
     */
    public function scopeIndex($query)
    {
        return $query->isEnabled()
            ->isParent()
            ->with('related')
            ->relatedFilter();
    }

    /**
     * Related Searches
     */
    public function scopeRelatedFilter($query)
    {
        return $query->has('listings', '>=', config('job-core.min_listings'))
            ->orderBy('value', 'asc');
    }

    /**
     * Parent Agencies
     */
    public function scopeIsParent($query)
    {
        return $query->whereNull('parent_code');
    }

    /**
     * Child Agencies
     */
    public function scopeIsChild($query)
    {
        return $query->whereNotNull('parent_code');
    }

    /**
     * Enabled Agencies
     */
    public function scopeIsEnabled($query)
    {
        return $query->whereDisabled(0);
    }

    /**
     * With Descriptions
     */
    public function scopeHasDescription($query)
    {
        return $query->whereNotNull('description');
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
