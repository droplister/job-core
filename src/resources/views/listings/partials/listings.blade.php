@include('job-core::listings.partials.listings-header')

@foreach($listings as $listing)
    @include('job-core::listings.partials.listing')
@endforeach

@if(count($listings) === 0)
    @include('job-core::listings.partials.listings-not-found')
@endif

@include('job-core::listings.partials.listings-footer')