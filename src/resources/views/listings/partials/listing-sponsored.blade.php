<p class="text-muted p-3 mb-0 small lh-135 border-bottom border-gray bg-sponsored">
    <a href="{{ $job->getUrl() }}" class="d-block font-weight-bold" target="_blank">
        {{ $job->getName() }}
    </a>
    <span class="d-block">
        {{ $job->getCompany() }}
        -
        {{ $job->getLocation() }}
    </span>
    <span class="d-block text-success">
        Sponsored Listing
    </span>
    <span class="d-block mt-1">
        {{ $job->getDescription() }}
    </span>
    <span class="d-block mt-1">
        Published {{ \Carbon\Carbon::instance($job->getDatePosted())->diffForHumans() }}
        <a href="{{ $job->getUrl() }}" class="ml-1" target="_blank">
            <i class="fa fa-external-link"></i> Apply Now
        </a>
    </span>
</p>