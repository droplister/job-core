@foreach($jobs->getItems() as $job)
    @include('job-core::listings.partials.job')
@endforeach