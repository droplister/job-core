<p class="text-muted pt-3 pb-4 mb-0 small lh-135 border-bottom border-gray">
    <span class="d-block mt-1">
        @guest
            No active listings. However, there have been {{ strtolower(config('job-core.keyword')) }} that matched your search in the past. If you would like to be notified the next time one gets published, <a href="{{ route('register') }}">sign up for free here</a>.
        </p>
        @else
            No active listings. <a href="{{ route('alerts.create') }}"><i class="fa fa-bell"></i> Create a job alert</a>.
        @endguest
    </span>
</p>