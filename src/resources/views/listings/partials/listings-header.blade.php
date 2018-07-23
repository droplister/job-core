@if(\Request::route()->getName() === 'listings.show')
    @include('partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Related Listings',
    ])
@elseif($listings->currentPage() === 1)
    @include('partials.h-tag', [
        'tag' => 'h6',
        'title' => $listings->total() . ' ' . str_plural('Job', $listings->total()) . ' Found',
    ])
@else
    @include('partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Page ' . $listings->currentPage() . ' of ' . $listings->lastPage(),
    ])
@endif