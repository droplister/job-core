@include('job-core::listings.partials.sponsored-listings')

@include('job-core::listings.partials.listings-header')

@if(count($listings) > 0)
	@foreach($listings as $listing)
	    @include('job-core::listings.partials.listing')
	@endforeach
@else
    @include('job-core::listings.partials.listings-not-found')
@endif

@include('job-core::listings.partials.listings-footer')