<?php

namespace Droplister\JobCore\App\Traits;

use Droplister\JobCore\App\Listing;
use Droplister\JobCore\App\AgencySubElements;

trait GuardsAgainst
{
    /**
     * Guard Against Non-Agencies
     *
     * @param  array  $data
     * @return boolean
     */
    private function guardAgainstNonAgencies($data)
    {
        return AgencySubElements::whereValue($data['value'])->doesntExist();
    }

	/**
	 * Guard Against Irrelevant Pages
     * 
	 * @param  $model
	 * @return boolean
	 */
	public function guardAgainstIrrelevantPages($model)
	{
        if($model->listings()->count() === 0 && $model->inactiveListings()->count() === 0)
        {
            return true;
        }

	    return false;
	}

    /**
     * Guard Agaisnt Disabled Listings
     * 
     * @param  \Droplister\JobCore\App\Listing  $listing
     * @return boolean
     */
    private function guardAgainstDisabledListings(Listing $listing)
    {
        return Cache::remember('listing_is_enabled_' . $listing->slug, 1440,
            function () use ($listing) {
                return ! Listing::listingsFilter()->get()->contains($listing);
            }
        );
    }

    /**
     * Guard Against Trashed
     *
     * @param  array  $data
     * @return boolean
     */
    private function guardAgainstTrashed($data)
    {
        return Listing::whereControlNumber($data['control_number'])
            ->onlyTrashed()
            ->exists();
    }

    /**
     * Guard Against International Locations
     *
     * @param  \Droplister\JobCore\App\Location  $location
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
     * Guard Against Washingon DC Cities
     *
     * @param  \Droplister\JobCore\App\Location  $location
     * @return boolean
     */
    private function guardAgainstWashingtonDcCities($location)
    {
        $city_name = str_replace(', District of Columbia', '', $location->CityName);

        return $city_name !== 'District of Columbia' && $city_name !== 'Washington DC';
    }
}