1
@foreach($jobs->items as $job)
    @include('job-core::listings.partials.job')
@endforeach
2
@foreach($jobs->items() as $job)
    @include('job-core::listings.partials.job')
@endforeach
3