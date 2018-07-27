<?php

namespace Droplister\JobCore\App;

use Cache;
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
        return Cache::rememberForever('agency_' . $this->slug . '_page_title',
            function () {
                return config('job-core.keyword') . ' for the ' . $this->value;
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
        return Cache::remember('agency_' . $this->slug . '_page_description', 1440,
            function () {               
                $listings = $this->listings()->paginate(3);
                $listings_count = $listings->total();

                if($this->description)
                {
                    $description = str_limit(strip_tags($this->description), 150);

                    return "{$listings_count} {$this->pageTitle} - {$description}";
                }
                elseif($listings_count > 2)
                {
                    foreach($listings as $listing)
                    {
                        $position = explode(', ', $listing->position_title);
                        $careers[] = $position[0];
                    }

                    $careers = array_map('title_case', $careers);

                    $description = "including {$careers[0]}, {$careers[1]}, and {$careers[2]}";

                    return "{$listings_count} {$this->pageTitle}, {$description}.";

                }
                else
                {
                    $domain = config('job-core.domain');
                    $description = "Find the one that is best suited to you on {$domain}";

                    return "{$listings_count} {$this->pageTitle} - {$description}.";
                }
            }
        );
    }

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
        return $query->relatedFilter()
            ->withCount('listings')
            ->orderBy('listings_count', 'desc')
            ->take(config('job-core.max_relations'));
    }

    /**
     * Index
     */
    public function scopeIndex($query)
    {
        return $query->isParent()
            ->relatedFilter()
            ->with('related');
    }

    /**
     * Related Searches
     */
    public function scopeRelatedFilter($query)
    {
        return $query->isEnabled()
            ->has('listings', '>=', config('job-core.min_listings'))
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
