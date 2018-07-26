<?php

namespace Droplister\JobCore\App\Console\Commands;

use Curl\Curl;
use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\Location;
use Droplister\JobCore\App\PayPlans;
use Droplister\JobCore\App\HiringPaths;
use Droplister\JobCore\App\AgencySubElements;
use Droplister\JobCore\App\OccupationalSeries;
use Droplister\JobCore\App\Traits\LinksUrls;
use Droplister\JobCore\App\Traits\LinksRelations;

use Illuminate\Console\Command;

class UsaJobsFetchDaily extends Command
{
    use LinksRelations, LinksUrls;

    /**
     * USAJobs.gov API
     *
     * @var Curl
     */
    protected $curl;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usajobs:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch USAJobs.gov API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->curl = new Curl();
        $this->curl->setHeader('Host', config('job-core.usajobs_host'));
        $this->curl->setHeader('User-Agent', config('job-core.usajobs_email'));
        $this->curl->setHeader('Authorization-Key', config('job-core.usajobs_key'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        AgencySubElements::chunk(25, function ($agencies)
        {
            foreach ($agencies as $agency)
            {
                $total_pages = $this->fetchApiPageCount($agency->code);

                for ($current_page = 1; $current_page <= $total_pages; $current_page++)
                {
                    $results = $this->fetchApiPageResults($agency->code, $current_page);

                    if(! $results) continue;

                    foreach ($results->SearchResult->SearchResultItems as $result)
                    {
                        $this->processResult($agency, $result);
                    }
                }

                if($total_pages) $agency->touch();

                $this->comment("Processed {$total_pages} page(s): {$agency->value}");
            }
        });
    }

    /**
     * Determine # of Pages
     *
     * @return integer
     */
    private function fetchApiPageCount($search)
    {
        $results = $this->fetchApiPageResults($search);

        // Catch Failed Fetch
        if (! $results) return 0;

        return ceil($results->SearchResult->SearchResultCountAll / 500);
    }

    /**
     * Return API Results
     *
     * @return object
     */
    private function fetchApiPageResults($search, $page=1)
    {
        $this->curl->get('https://data.usajobs.gov/api/Search?Page='. $page .'&ResultsPerPage=500&Organization=' . $search);

        return json_decode($this->curl->response);
    }

    /**
     * Process Single Result
     *
     * @return void
     */
    private function processResult($agency, $result)
    {
        // API Result Data
        $data = $this->fetchDataArray($result);

        // No Trashed Data
        if($this->guardAgainstTrashed($data)) return false;

        // Create Listing
        $listing = $this->firstOrCreateListing($data);

        // Always Sync Agency
        $this->syncAgency($listing, $agency);

        // Handle New Listing
        if($listing->wasRecentlyCreated)
        {
            // Link Relations
            $this->linkRelations($listing);

            // Sync Locations
            $this->syncLocations($listing, $result);

            // Sync HiringPaths
            $this->syncHiringPaths($listing, $result);

            // Sync OccupationalSeries
            $this->syncOccupationalSeries($listing, $result);

            // Sync PayPlans
            $this->syncPayPlans($listing, $result);
        }
    }

    /**
     * In-Memory Data Blob
     *
     * @return array
     */
    private function fetchDataArray($result)
    {
        $control_number = $result->MatchedObjectId;
        $position_id = $result->MatchedObjectDescriptor->PositionID;
        $position_title = $result->MatchedObjectDescriptor->PositionTitle;
        $position_uri = $result->MatchedObjectDescriptor->ApplyURI[0];
        $position_location_display = $result->MatchedObjectDescriptor->PositionLocationDisplay;
        $position_schedule = $result->MatchedObjectDescriptor->PositionSchedule[0]->Name;
        $position_schedule_code = $result->MatchedObjectDescriptor->PositionSchedule[0]->Code;
        $position_offering_type = $result->MatchedObjectDescriptor->PositionOfferingType[0]->Name;
        $position_offering_type_code = $result->MatchedObjectDescriptor->PositionOfferingType[0]->Code;
        $minimum_range = $result->MatchedObjectDescriptor->PositionRemuneration[0]->MinimumRange;
        $maximum_range = $result->MatchedObjectDescriptor->PositionRemuneration[0]->MaximumRange;
        $rate_interval_code = $result->MatchedObjectDescriptor->PositionRemuneration[0]->RateIntervalCode;
        $who_may_apply_code = $result->MatchedObjectDescriptor->UserArea->Details->WhoMayApply->Code;
        $job_grade_code = $result->MatchedObjectDescriptor->JobGrade[0]->Code;
        $low_grade = $result->MatchedObjectDescriptor->UserArea->Details->LowGrade;
        $high_grade = $result->MatchedObjectDescriptor->UserArea->Details->HighGrade;
        $job_summary = $this->urlsToHtml($result->MatchedObjectDescriptor->UserArea->Details->JobSummary);
        $who_may_apply = $this->urlsToHtml($result->MatchedObjectDescriptor->UserArea->Details->WhoMayApply->Name);
        $qualification_summary = $this->urlsToHtml($result->MatchedObjectDescriptor->QualificationSummary);
        $position_start_date = substr(trim($result->MatchedObjectDescriptor->PositionStartDate), 0, 10);
        $position_end_date = substr(trim($result->MatchedObjectDescriptor->PositionEndDate), 0, 10);
        $publication_start_date = substr(trim($result->MatchedObjectDescriptor->PublicationStartDate), 0, 10);
        $application_close_date = substr(trim($result->MatchedObjectDescriptor->ApplicationCloseDate), 0, 10);

        return array_map('trim', compact('control_number', 'position_id', 'position_title', 'position_uri', 'position_location_display', 'position_schedule', 'position_schedule_code', 'position_offering_type', 'position_offering_type_code', 'qualification_summary',  'minimum_range', 'maximum_range', 'rate_interval_code', 'job_summary', 'who_may_apply',  'who_may_apply_code', 'job_grade_code', 'low_grade', 'high_grade', 'position_start_date', 'position_end_date', 'publication_start_date', 'application_close_date'));
    }

    /**
     * First or Create Listing
     *
     * @return Listing
     */
    private function firstOrCreateListing($data)
    {
        return Listing::firstOrCreate(
            array_only($data, ['control_number']),
            array_except($data, ['control_number'])
        );
    }

    /**
     * First or Create Location
     *
     * @return Location
     */
    private function firstOrCreateLocation($parent_id, $type, $name, $location=null, $title=null)
    {
        if($location)
        {
            return Location::firstOrCreate([
                'parent_id' => $parent_id,
                'type' => $type,
                'name' => trim($name),
                'title' => $title ? trim($title) : trim($name),
            ],[
                'longitude' => $location->Longitude,
                'latitude' => $location->Latitude,
            ]);
        }
        else
        {
            return Location::firstOrCreate([
                'parent_id' => $parent_id,
                'type' => $type,
                'name' => trim($name),
                'title' => $title ? trim($title) : trim($name),
            ]);
        }
    }

    /**
     * Sync Agency
     *
     * @return void
     */
    private function syncAgency($listing, $agency)
    {
        return $listing->agencies()->sync([$agency->id], false);
    }

    /**
     * Sync Locations
     *
     * @return void
     */
    private function syncLocations($listing, $result)
    {
        foreach($result->MatchedObjectDescriptor->PositionLocation as $location)
        {
            if($this->guardAgainstInternationalLocation($location))
            {
                $listing->delete();
                break;
            }

            $country = $this->firstOrCreateLocation(null, 'country', $location->CountryCode);

            $locations[] = $country->id;

            if(isset($location->CountrySubDivisionCode))
            {
                if('District of Columbia' === $location->CountrySubDivisionCode)
                {
                    $locations = $this->handleDistrictOfColumbia($locations, $location, $country);
                }
                else
                {
                    $locations = $this->handleCityState($locations, $location, $country);
                }
            }
            else
            {
                $locations = $this->handleCityCountry($locations, $location, $country);
            }

            $listing->locations()->sync($locations, false);
        }
    }

    /**
     * Sync Hiring Paths
     *
     * @return void
     */
    private function syncHiringPaths($listing, $result)
    {
        $paths = [];

        foreach($result->MatchedObjectDescriptor->UserArea->Details->HiringPath as $hiring_path)
        {
            $path = HiringPaths::whereCode($hiring_path)->first();

            $paths[] = $path->id;
        }

        $listing->hiringPaths()->sync($paths, false);
    }

    /**
     * Sync Occupational Series
     *
     * @return void
     */
    private function syncOccupationalSeries($listing, $result)
    {
        $careers = [];

        foreach($result->MatchedObjectDescriptor->JobCategory as $job_category)
        {
            $category = OccupationalSeries::whereCode($job_category->Code)->first();

            $careers[] = $category->id;
        }

        $listing->careers()->sync($careers, false);
    }

    /**
     * Sync Pay Plans
     *
     * @return void
     */
    private function syncPayPlans($listing, $result)
    {
        if (! empty($result->MatchedObjectDescriptor->JobGrade))
        {
            $code = trim($result->MatchedObjectDescriptor->JobGrade[0]->Code);

            $payplan = PayPlans::whereCode($code)->first();

            $listing->payplans()->sync([$payplan->id], false);
        }
    }

    /**
     * Handle City Country
     *
     * @return array
     */
    private function handleCityCountry($locations, $location, $country)
    {
        $name = str_replace(", {$country->name}", "", $location->CityName);

        $city = $this->firstOrCreateLocation($country->id, 'city', $name, $location, $location->CityName);

        $locations[] = $city->id;

        return $locations;
    }

    /**
     * Handle City State
     *
     * @return array
     */
    private function handleCityState($locations, $location, $country)
    {
        $state = $this->firstOrCreateLocation($country->id, 'state', $location->CountrySubDivisionCode);

        $locations[] = $state->id;

        $name = str_replace(", {$state->name}", "", $location->CityName);

        $city = $this->firstOrCreateLocation($state->id, 'city', $name, $location, $location->CityName);

        $locations[] = $city->id;

        return $locations;
    }

    /**
     * Handle DC
     *
     * @return array
     */
    private function handleDistrictOfColumbia($locations, $location, $country)
    {
        $state = $this->firstOrCreateLocation($country->id, 'state', 'Washington DC');

        $locations[] = $state->id;

        if($this->guardAgainstWashingtonDcCities($location))
        {
            $name = str_replace(", District of Columbia", "", $location->CityName);

            $city = $this->firstOrCreateLocation($state->id, 'city', $name, $location);

            $locations[] = $city->id;
        }

        return $locations;
    }

    /**
     * Guard Against Data
     *
     * @return boolean
     */
    private function guardAgainstTrashed($data)
    {
        return Listing::whereControlNumber($data['control_number'])
            ->onlyTrashed()
            ->exists();
    }

    /**
     * Guard Against Data
     *
     * @return boolean
     */
    private function guardAgainstInternationalLocation($location)
    {
        return 'United States' !== $location->CountryCode ||
        isset($location->CountrySubDivisionCode) &&
        in_array($location->CountrySubDivisionCode, [
            'Northern Mariana Islands',
            'American Samoa',
            'Guam',
            'Puerto Rico',
            'Virgin Islands'
        ]);
    }

    /**
     * Guard Against Data
     *
     * @return boolean
     */
    private function guardAgainstWashingtonDcCities($location)
    {
        $city_name = str_replace(', District of Columbia', '', $location->CityName);

        return $city_name !== 'District of Columbia' && $city_name !== 'Washington DC';
    }
}