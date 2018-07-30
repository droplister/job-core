@if(isset($sponsored))
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Featured Jobs',
    ])
    @foreach($sponsored->all() as $job)
        @include('job-core::listings.partials.listing-sponsored')
        @if($loop->iteration == config('job-core.max_sponsored')) @break @endif
    @endforeach
@endif
@if(\Request::route()->getName() === 'listings.show')
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Related Listings',
    ])
@elseif($listings->currentPage() === 1)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => $listings->total() . ' ' . str_plural('Job', $listings->total()) . ' Found',
        'mt' => isset($sponsored) ? 'mt-4' : '',
    ])
@else
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Page ' . $listings->currentPage() . ' of ' . $listings->lastPage(),
        'mt' => isset($sponsored) ? 'mt-4' : '',
    ])
@endif