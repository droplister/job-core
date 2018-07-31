@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => config('job-core.domain'),
    'mb' => 'mb-3',
])
<p class="text-muted small lh-135">
    {{ config('job-core.domain') }} is a free {{ strtolower(config('job-core.keyword')) }} search tool powered by the <a href="https://developer.usajobs.gov/" target="_blank">USAJobs.gov API</a> offered for free by <a href="https://familymediallc.com/">Family Media LLC</a>. If you would like to get in touch with us about a problem, a business opportunity, or any other matter, please use our <a href="{{ route('contact.create') }}">contact form</a>.
</p>
<p class="text-muted small lh-135">
    If this is your first time to {{ config('job-core.domain') }}, we recommend checking out our <a href="{{ route('alerts.index') }}">free job alerts</a>. And, in addition, we have listed several resources below which will help you apply for {{ strtolower(config('job-core.keyword')) }}, if you need.
</p>
@include('job-core::partials.resources')