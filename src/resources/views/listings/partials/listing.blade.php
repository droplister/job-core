<p class="text-muted pt-3 pb-3 mb-0 small lh-135 border-bottom border-gray">
    <a href="{{ route('listings.show', ['listing' => $listing->slug]) }}" class="d-block font-weight-bold">
        {{ $listing->title }}
    </a>
    <span class="d-block">
        {{ $listing->agency }} - {{ $listing->position_location_display }}
    </span>
    <span class="d-block text-success">
        {{ $listing->pay_range }}
    </span>
    <span class="d-block mt-1">
        {{ $listing->pageDescription }}
    </span>
    <span class="d-block mt-1">
        Published {{ $listing->publication_start_date->diffForHumans() }}
        <a href="{{ $listing->position_uri }}" class="ml-2" target="_blank">
            <i class="fa fa-external-link"></i> Apply Now
        </a>
        <a href="{{ route('referral.create', ['listing' => $listing->slug]) }}" class="ml-2 d-none d-sm-inline">
            <i class="fa fa-envelope-o"></i> Email Job
        </a>
    </span>
</p>