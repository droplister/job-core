@include('job-core::listings.partials.listings-header')

@if(isset($sponsored))
	@foreach($sponsored->all() as $job)
	    @include('job-core::listings.partials.listing-sponsored')
	    @if($loop->iteration === 2) @break @endif
	@endforeach
@endif

@foreach($listings as $listing)
    @include('job-core::listings.partials.listing')
@endforeach

@include('job-core::listings.partials.listings-footer')