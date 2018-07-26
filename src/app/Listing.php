<?php

namespace Droplister\JobCore\App;

use Cache;
use Carbon\Carbon;
use Droplister\JobCore\App\Traits\ChunksParagraphs;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use ChunksParagraphs, Sluggable, SluggableScopeHelpers, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'control_number',
        'position_id',
        'organization_code',
        'department_code',
        'position_title',
        'position_uri',
        'position_location_display',
        'position_schedule',
        'position_schedule_code',
        'position_offering_type',
        'position_offering_type_code',
        'qualification_summary',
        'minimum_range',
        'maximum_range',
        'rate_interval_code',
        'job_summary',
        'who_may_apply',
        'who_may_apply_code',
        'job_grade_code',
        'low_grade',
        'high_grade',
        'clearance_code',
        'travel_percentage_code',
        'military_base_flag',
        'internship_flag',
        'clearance_flag',
        'position_start_date',
        'position_end_date',
        'publication_start_date',
        'application_close_date',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'position_start_date',
        'position_end_date',
        'publication_start_date',
        'application_close_date',
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'agency',
        'career',
        'description',
        'job_grade',
        'pay_range',
        'subtitle',
        'summary',
        'title',
    ];

    /**
     * Agency
     *
     * @return string
     */
    public function getAgencyAttribute()
    {
        return Cache::rememberForever('listing_' . $this->slug . '_agency',
            function () {
                if($this->agencies()->isChild()->count() === 1)
                {
                    $agency = $this->agencies()->isChild()->first();
                }
                elseif($this->agencies()->isChild()->count() > 1)
                {
                    $agency = $this->agencies()->doesntHave('children')->first();
                }
                else
                {
                    $agency = $this->agencies()->first();
                }

                return $agency ? $agency->value : null;
            }
        );
    }

    /**
     * Career
     *
     * @return string
     */
    public function getCareerAttribute()
    {
        return Cache::rememberForever('listing_' . $this->slug . '_career',
            function () {
                $career = $this->careers()->isChild()->first();

                return $career ? $career->value : null;
            }
        );
    }

    /**
     * Description
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return Cache::rememberForever('listing_' . $this->slug . '_description',
            function () {               
                return "{$this->subtitle}. {$this->summary}";
            }
        );
    }

    /**
     * Job Grade
     *
     * @return string
     */
    public function getJobGradeAttribute()
    {
        return Cache::rememberForever('listing_' . $this->slug . '_job_grade',
            function () {               
                $grade = $this->low_grade === $this->high_grade ? $this->low_grade : "{$this->low_grade}/{$this->high_grade}";

                if($this->careers()->exists())
                {
                    return "{$this->job_grade_code}-{$this->careers()->first()->code}-{$grade}";
                }

                return "{$this->job_grade_code}-{$grade}";
            }
        );
    }

    /**
     * Pay Range
     *
     * @return string
     */
    public function getPayRangeAttribute()
    {
        return Cache::rememberForever('listing_' . $this->slug . '_pay_range',
            function () {               
                if($this->minimum_range + $this->maximum_range > 0)
                {
                    $minimum = str_replace('.00', '', number_format($this->minimum_range, 2));
                    $maximum = str_replace('.00', '', number_format($this->maximum_range, 2));

                    return '$' . $minimum . '-$' . $maximum . ' ' . $this->rate_interval_code;
                }
                else
                {
                    return 'Without Compensation';
                }
            }
        );
    }

    /**
     * Subitle
     *
     * @return string
     */
    public function getSubtitleAttribute()
    {
        return Cache::rememberForever('listing_' . $this->slug . '_subtitle',
            function () {               
                $career = $this->career ? $this->career . ' Job' : 'Job';
                $agency = $this->agency ? $this->agency : 'Federal Government';

                return "{$career} for the {$agency} in {$this->position_location_display}";
            }
        );
    }

    /**
     * Summary
     *
     * @return string
     */
    public function getSummaryAttribute()
    {
        return Cache::rememberForever('listing_' . $this->slug . '_summary',
            function () {               
                $summary = $this->qualification_summary ? $this->qualification_summary : $this->job_summary;

                return str_limit(strip_tags($summary));
            }
        );
    }

    /**
     * Title
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        return Cache::rememberForever('listing_' . $this->slug . '_title',
            function () {               
                $title = "{$this->position_title} ({$this->position_id})";

                return $this->agency ? "{$title} - {$this->agency}" : $title;
            }
        );
    }

    /**
     * Mutate Position Location Display
     *
     * @return string
     */
    public function getPositionLocationDisplayAttribute($value)
    {
        if('Washington DC, District of Columbia' === $value) return 'Washington DC';

        return $value;
    }

    /**
     * Agencies
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agencies()
    {
        return $this->belongsToMany(AgencySubElements::class, 'listing_agency_sub_element', 'listing_id', 'agency_sub_element_id');
    }

    /**
     * Related Agencies
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function relatedAgencies()
    {
        return $this->belongsToMany(AgencySubElements::class, 'listing_agency_sub_element', 'listing_id', 'agency_sub_element_id')->take(config('job-core.max_relations'))->orderBy('parent_code', 'asc');
    }

    /**
     * Careers
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function careers()
    {
        return $this->belongsToMany(OccupationalSeries::class, 'listing_occupational_series', 'listing_id', 'occupational_series_id');
    }

    /**
     * Related Careers
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function relatedCareers()
    {
        return $this->belongsToMany(OccupationalSeries::class, 'listing_occupational_series', 'listing_id', 'occupational_series_id')->take(config('job-core.max_relations'));
    }

    /**
     * Clearances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clearances()
    {
        return $this->belongsToMany(SecurityClearances::class, 'listing_security_clearance', 'listing_id', 'security_clearance_id');
    }

    /**
     * Locations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }

    /**
     * Related Locations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function relatedLocations()
    {
        return $this->belongsToMany(Location::class)->isCity()->take(config('job-core.max_relations'));
    }

    /**
     * Hiring Paths
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hiringPaths()
    {
        return $this->belongsToMany(HiringPaths::class, 'listing_hiring_path', 'listing_id', 'hiring_path_id');
    }

    /**
     * Pay Plans
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payplans()
    {
        return $this->belongsToMany(PayPlans::class, 'listing_pay_plan', 'listing_id', 'pay_plan_id');
    }

    /**
     * Travel %
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function travel()
    {
        return $this->belongsTo(TravelPercentage::class, 'travel_percentage_code', 'code');
    }

    /**
     * Schedule
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schedule()
    {
        return $this->belongsTo(PositionSchedule::class, 'position_schedule_code', 'code');
    }

    /**
     * Listing Filter
     */
    public function scopeListingFilter($query)
    {
        switch(config('job-core.filter'))
        {
            case 'federal': 
                return $query->isActive()
                    ->notInternship()
                    ->latest('publication_start_date');
            case 'internship': 
                return $query->isActive()
                    ->isInternship()
                    ->latest('publication_start_date');
            case 'military_base': 
                return $query->isActive()
                    ->onMilitaryBase()
                    ->notInternship()
                    ->latest('publication_start_date');
            case 'security_clearance': 
                return $query->isActive()
                    ->isCleared()
                    ->notInternship()
                    ->latest('publication_start_date');
            case 'senior_executive': 
                return $query->isActive()
                    ->isSeniorExecutive()
                    ->latest('publication_start_date');
            default:
                return $query->isActive()
                    ->latest('publication_start_date');
        }
    }

    /**
     * Index
     */
    public function scopeIndex($query)
    {
        return $query->listingFilter();
    }

    /**
     * Most
     */
    public function scopeMost($query)
    {
        switch(config('job-core.filter'))
        {
            case 'federal': 
                return $query->listingFilter()
                    ->whereHas('careers',
                        function ($career) {
                            $career->where('job_family', '=', '0800');
                        }
                    );
            case 'internship': 
                return $query->listingFilter()
                    ->where('minimum_range', '>', 0)
                    ->orderBy('maximum_range', 'desc');
            case 'military_base': 
                return $query->listingFilter()
                    ->where('position_schedule_code', '=', 2)
                    ->orderBy('maximum_range', 'desc');
            case 'security_clearance': 
                return $query->listingFilter()
                    ->where('maximum_range', '>', 99999)
                    ->orderBy('maximum_range', 'desc');
            default:
                return $query->listingFilter();
        }
    }

    /**
     * Specific
     */
    public function scopeSpecific($query)
    {
        switch(config('job-core.filter'))
        {
            case 'federal': 
                return $query->listingFilter()
                    ->whereHas('careers',
                        function ($career) {
                            $career->where('job_family', '=', '0600');
                        }
                    );
            case 'internship': 
                return $query->listingFilter()
                    ->where('minimum_range', '=', 0)
                    ->where('maximum_range', '=', 0);
            case 'military_base': 
                return $query->listingFilter()
                    ->whereHas('hiringPaths',
                        function ($path) {
                            $path->where('code', '=', 'VET');
                        }
                    );
            case 'security_clearance': 
                return $query->listingFilter()
                    ->whereHas('hiringPaths',
                        function ($path) {
                            $path->where('code', '=', 'VET');
                        }
                    );
            default:
                return $query->listingFilter();
        }
    }

    /**
     * Search
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where('position_title', 'like', '%' . $keyword . '%')
            ->listingFilter();
    }

    /**
     * Narrow
     */
    public function scopeNarrow($query, $relationship, $slug)
    {
        return $query->whereHas($relationship,
            function ($q) use ($slug) {
                $q->where('slug', '=', $slug);
            }
        );
    }

    /**
     * Related
     */
    public function scopeRelated($query, $listing)
    {
        return $query->whereNotIn('id', [$listing->id])
            ->whereHas('careers',
                function ($career) use ($listing) {
                    $career->whereIn('id', $listing->careers()->pluck('id')->all());
                }
            )
            ->whereJobGradeCode($listing->job_grade_code)
            ->where('low_grade', '>=', $listing->low_grade)
            ->where('high_grade', '<=', $listing->high_grade)
            ->inRandomOrder()
            ->listingFilter()
            ->orWhereNotIn('id', [$listing->id])
            ->whereHas('careers',
                function ($career) use ($listing) {
                    $career->whereIn('id', $listing->careers()->pluck('id')->all());
                }
            )
            ->inRandomOrder()
            ->listingFilter()
            ->take(config('job-core.max_related'));
    }

    /**
     * Fresh
     */
    public function scopeIsFresh($query)
    {
        return $query->where('publication_start_date', '>', Carbon::now()->subDays(7));
    }

    /**
     * Active
     */
    public function scopeIsActive($query)
    {
        return $query->where('application_close_date', '>', Carbon::now()->toDateString());
    }

    /**
     * Not Active
     */
    public function scopeNotActive($query)
    {
        return $query->where('application_close_date', '<', Carbon::now()->toDateString());
    }

    /**
     * Cleared
     */
    public function scopeIsCleared($query)
    {
        return $query->where('clearance_flag', 1);
    }

    /**
     * On Military Base
     */
    public function scopeOnMilitaryBase($query)
    {
        return $query->where('military_base_flag', 1);
    }

    /**
     * Off Military Base
     */
    public function scopeOffMilitaryBase($query)
    {
        return $query->where('military_base_flag', 0);
    }

    /**
     * Not Cleared
     */
    public function scopeNotCleared($query)
    {
        return $query->where('clearance_flag', 0);
    }

    /**
     * Internships
     */
    public function scopeIsInternship($query)
    {
        return $query->where('internship_flag', 1);
    }

    /**
     * Not Internships
     */
    public function scopeNotInternship($query)
    {
        return $query->where('internship_flag', 0);
    }

    /**
     * Senior Executive
     */
    public function scopeIsSeniorExecutive($query)
    {
        return $query->whereHas('hiringPaths',
            function ($path) {
                return $path->where('slug', '=', 'senior-executives');
            }
        );
    }

    /**
     * Not Senior Executive
     */
    public function scopeNotSeniorExecutive($query)
    {
        return $query->whereDoesntHave('hiringPaths',
            function ($path) {
                return $path->where('slug', '=', 'senior-executives');
            }
        );
    }

    /**
     * By Schedule
     */
    public function scopeWhereHasSchedule($query, $schedule)
    {
        return $query->where('position_schedule_code', $schedule);
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
                'source' => ['position_title', 'control_number'],
            ]
        ];
    }
}