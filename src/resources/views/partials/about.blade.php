@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => config('job-core.domain'),
    'mb' => 'mb-3',
])
<p class="text-muted small lh-135">
    {{ config('job-core.domain') }} is a free {{ strtolower(config('job-core.keyword')) }} search tool powered by the <a href="https://developer.usajobs.gov/" target="_blank">USAJobs.gov API</a> offered for free by <a href="https://familymediallc.com/">Family Media LLC</a>.
</p>
@include('job-core::partials.resources')