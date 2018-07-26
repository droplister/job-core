@if(isset($sponsored))
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Sponsored',
    ])
	@foreach($sponsored->all() as $job)
	    @include('job-core::listings.partials.listing-sponsored')
	    @if($loop->iteration === 1) @break @endif
	@endforeach
@endif

@include('job-core::listings.partials.listings-header')

@foreach($listings as $listing)
    @include('job-core::listings.partials.listing')
@endforeach

@include('job-core::listings.partials.listings-footer')