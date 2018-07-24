@foreach($jobs->items as $job)
    @include('job-core::listings.partials.job')
@endforeach