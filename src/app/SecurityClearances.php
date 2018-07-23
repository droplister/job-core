<?php

namespace Droplister\JobCore\App;

use Droplister\JobCore\App\Traits\NarrowsListings;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class SecurityClearances extends Model
{
    use NarrowsListings, Sluggable, SluggableScopeHelpers;

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
     * Securty Clearance Careers
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function careers()
    {
        return $this->hasManyThrough(OccupationalSeries::class, Listing::class, 'clearance_code', 'code', 'code');
    }

    /**
     * Securty Clearance Listings
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'listing_security_clearance', 'security_clearance_id', 'listing_id')->listingFilter();
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
