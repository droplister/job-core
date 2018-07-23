<?php

namespace Droplister\JobCore\App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class PayPlans extends Model
{
    use Sluggable, SluggableScopeHelpers;

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
     * Pay Plan Listings
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'listing_pay_plan', 'pay_plan_id', 'listing_id')->listingFilter();
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
