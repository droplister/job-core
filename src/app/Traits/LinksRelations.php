<?php

namespace Droplister\JobCore\App\Traits;

use Droplister\JobCore\App\Location;
use Droplister\JobCore\App\AgencySubElements;

trait LinksRelations
{
    /**
     * Plain-Text -> HTML
     */
    public function linkRelations($listing)
    {
        $locations = Location::where('type', '!=', 'country')
            ->has('listings', '>=', config('job-core.min_listings'))
            ->get();

        $agencies = AgencySubElements::has('listings', '>=', config('job-core.min_listings'))->get();

        foreach($locations as $location)
        {
            $url = route('locations.show', ['location' => $location->slug]);
            $this->insertLinks($listing, $location->title, $url);
        }

        foreach($agencies as $agency)
        {
            $url = route('agencies.show', ['agency' => $agency->slug]);
            $this->insertLinks($listing, $agency->value, $url);
        }
    }

    /**
     * Insert Links
     *
     * @return string
     */
    private function insertLinks($listing, $title, $url)
    {
        $listing->qualification_summary = $this->searchReplace($listing->qualification_summary, $title, $url);
        $listing->job_summary = $this->searchReplace($listing->job_summary, $title, $url);
        $listing->save();
    }

    /**
     * Search and Replace
     *
     * @return string
     */
    private function searchReplace($haystack, $needle, $url)
    {
        $pos = strpos($haystack, $needle);

        if ($pos !== false) {
            $replace = '<a href="' . $url . '">' . $needle . '</a>';
            $haystack = substr_replace($haystack, $replace, $pos, strlen($needle));
        }

        return $haystack;
    }
}
