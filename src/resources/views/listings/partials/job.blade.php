<p class="text-muted pt-3 pb-3 mb-0 small lh-135 border-bottom border-gray bg-warning">
    <a href="{{ $job['url'] }}" class="d-block font-weight-bold" target="_blank">
        {{ $job['name'] }}
    </a>
    <span class="d-block">
        {{ $job['company'] }}
        -
        {{ $job['location'] }}
    </span>
    <span class="d-block text-success">
        Sponsored Job Listing
    </span>
    <span class="d-block mt-1">
        {{ $job['description'] }}
    </span>
    <span class="d-block mt-1">
        Published {{ $job['datePosted'] }}
        <a href="{{ $job['url'] }}" class="ml-1" target="_blank">
            <i class="fa fa-external-link"></i> Apply Now
        </a>
    </span>
  </p>