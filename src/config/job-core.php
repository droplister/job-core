<?php

return [

    /**
     * Filter
     */
    'filter' => env('JOB_CORE_FILTER'),

    /**
     * Body
     */
    'body_class' => env('JOB_CORE_BODY_CLASS', 'bg-light'),

    /**
     * Nav
     */
    'nav_class' => env('JOB_CORE_NAV_CLASS', 'navbar-dark bg-dark'),

    /**
     * Icon
     */
    'icon_class' => env('JOB_CORE_ICON_CLASS', 'fa-user'),

    /**
     * Search
     */
    'search_class' => env('JOB_CORE_SEARCH_CLASS', 'btn-outline-success'),

    /**
     * Subnav
     */
    'subnav_class' => env('JOB_CORE_SUBNAV_CLASS', 'bg-white'),

    /**
     * Title
     */
    'title_class' => env('JOB_CORE_TITLE_CLASS', 'text-white-50 bg-dark'),

    /**
     * Button
     */
    'button_class' => env('JOB_CORE_BUTTON_CLASS', 'btn-primary'),

    /**
     * Domain
     */
    'domain' => env('JOB_CORE_DOMAIN', 'FedHire.com'),

    /**
     * Keyword
     */
    'keyword' => env('JOB_CORE_KEYWORD', 'Federal Government Jobs'),

    /**
     * Keyword Alt
     */
    'keyword_alt' => env('JOB_CORE_KEYWORD_ALT', 'Federal Government'),

    /**
     * Keyword Root
     */
    'keyword_root' => env('JOB_CORE_KEYWORD_ROOT', 'Federal Government'),

    /**
     * Tagline
     */
    'tagline' => env('JOB_CORE_TAGLINE', 'Find a federal government job.'),

    /**
     * Most Icon
     */
    'most_icon' => env('JOB_CORE_MOST_ICON', 'fa-money'),

    /**
     * Most Title
     */
    'most_title' => env('JOB_CORE_MOST_TITLE', 'Six Figure'),

    /**
     * Most Slug
     */
    'most_route' => env('JOB_CORE_MOST_ROUTE', '/most-salary'),

    /**
     * Specific Icon
     */
    'specific_icon' => env('JOB_CORE_SPECIFIC_ICON', 'fa-star'),

    /**
     * Specific Title
     */
    'specific_title' => env('JOB_CORE_SPECIFIC_TITLE', 'Veterans'),

    /**
     * Specific Slug
     */
    'specific_route' => env('JOB_CORE_SPECIFIC_ROUTE', '/veterans'),

    /**
     * Affiliate Slug
     */
    'affiliate_route' => env('JOB_CORE_AFFILIATE_ROUTE', '/amazon'),

    /**
     * Monetized
     */
    'monetized' => env('JOB_CORE_MONETIZED', false),

    /**
     * Adsense Ad Client
     */
    'google_ad_client' => env('JOB_CORE_GOOGLE_AD_CLIENT'),

    /**
     * Adsense Ad Slot
     */
    'google_ad_slot' => env('JOB_CORE_GOOGLE_AD_SLOT'),

    /**
     * JuJu.com Parner ID
     */
    'partner_id' => env('JOB_CORE_PARTNER_ID'),

    /**
     * Affiliate Link
     */
    'affiliate_url' => env('JOB_CORE_AFFILIATE_URL', env('APP_URL')),

    /**
     * USAJobs.gov Host
     */
    'usajobs_host' => env('JOB_CORE_USAJOBS_HOST'),

    /**
     * USAJobs.gov Email
     */
    'usajobs_email' => env('JOB_CORE_USAJOBS_EMAIL'),

    /**
     * USAJobs.gov Key
     */
    'usajobs_key' => env('JOB_CORE_USAJOBS_KEY'),

    /**
     * Listings Per Page
     */
    'per_page' => env('JOB_CORE_PER_PAGE', 30),

    /**
     * Max Sponsored Listings
     */
    'max_sponsored' => env('JOB_CORE_MAX_SPONSORED', 2),

    /**
     * Listing String Limit
     */
    'str_limit' => env('JOB_CORE_STR_LIMIT', 300),

    /**
     * Max Model Relations
     */
    'max_relations' => env('JOB_CORE_MAX_RELATIONS', 10),

    /**
     * Min Listings to Matter
     */
    'min_listings' => env('JOB_CORE_MIN_LISTINGS', 5),

    /**
     * Max Related Listings
     */
    'max_related' => env('JOB_CORE_MAX_RELATED', 3),

    /**
     * Google Map Coordinates
     */
    'google_map' => [
        'lat' => env('JOB_CORE_GOOGLE_MAP_LAT', 39.8283),
        'lng' => env('JOB_CORE_GOOGLE_MAP_LNG', -98.5795),
        'zoom' => env('JOB_CORE_GOOGLE_MAP_ZOOM', 3)
    ],
];