@include('job-core::partials.p-tag', [
    'text' => config('job-core.domain') . ' is a free ' . strtolower(config('job-core.keyword')) . ' search tool powered by the USAJobs.gov API offered for free by Family Media LLC.',
])
@include('job-core::partials.resources')