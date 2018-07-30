@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => config('job-core.domain'),
    'mb' => 'mb-3',
])
<p class="text-muted small lh-135">
    {{ config('job-core.domain') }} is a free {{ strtolower(config('job-core.keyword')) }} search tool powered by the USAJobs.gov API offered for free by Family Media LLC.
</p>
@include('job-core::partials.resources')