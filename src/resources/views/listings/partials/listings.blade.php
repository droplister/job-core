@include('listings.partials.listings-header')

@foreach($listings as $listing)
    @include('listings.partials.listing')
@endforeach

@include('listings.partials.listings-footer')