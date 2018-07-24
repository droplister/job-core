@foreach($jobs->all() as $job)
    @include('job-core::listings.partials.job')
@endforeach