@include('job-core::listings.partials.listings-header')

@foreach($listings as $listing)
    @include('job-core::listings.partials.listing')
@endforeach

@include('job-core::listings.partials.listings-footer')