<p class="text-muted pt-3 pb-3 mb-0 small lh-135 border-bottom border-gray">
    <a href="{{ route('listings.show', ['listing' => $listing->slug]) }}" class="d-block font-weight-bold">
        {{ $listing->position_title }}
    </a>
    <span class="d-block">
        @if(\Request::route()->getName() === 'agencies.show')
               {{ $listing->careers()->isChild()->first() ? $listing->careers()->isChild()->first()->value : $listing->careers()->first()->value }}
        @else
            {{ $listing->agencies()->isChild()->first() ? $listing->agencies()->isChild()->first()->value : $listing->agencies()->first()->value }}
        @endif
        -
        @if(\Request::route()->getName() === 'locations.show' && $location->type === 'city')
            {{ $listing->careers()->isChild()->first() ? $listing->careers()->isChild()->first()->value : $listing->careers()->first()->value }}
        @else
            @if($listing->position_location_display !== 'Multiple Locations')
            {{ $listing->position_location_display }}
            @else
            {{ $listing->careers()->isChild()->first() ? $listing->careers()->isChild()->first()->value : $listing->careers()->first()->value }}
            @endif
        @endif
    </span>
    <span class="d-block text-success">
        @if($listing->minimum_range === $listing->maximum_range && $listing->minimum_range + $listing->maximum_range > 0)
            ${{ str_replace('.00', '', number_format($listing->maximum_range, 2)) . ' ' . $listing->rate_interval_code }}
        @else
            {{ $listing->minimum_range + $listing->maximum_range > 0 ? '$' . str_replace('.00', '', number_format($listing->minimum_range, 2)) . ' - $' . str_replace('.00', '', number_format($listing->maximum_range, 2)) . ' ' . $listing->rate_interval_code : 'Without Compensation' }}
        @endif
    </span>
    <span class="d-block mt-1">
        {{ $listing->description }}
    </span>
    <span class="d-block mt-1">
        Published {{ $listing->publication_start_date->diffForHumans() }}
        <a href="{{ $listing->position_uri }}" class="ml-1" target="_blank">
            <i class="fa fa-external-link"></i> Apply Now
        </a>
    </span>
  </p>