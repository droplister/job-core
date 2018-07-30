<?php

namespace Droplister\JobCore\App;

use Droplister\JobCore\App\Traits\NarrowsListings;
use Droplister\JobCore\App\Traits\SponsoredListings;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class PositionSchedule extends Model
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
     * Position Schedule Listings
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->hasMany(Listing::class, 'position_schedule_code', 'code')->listingsFilter();
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
