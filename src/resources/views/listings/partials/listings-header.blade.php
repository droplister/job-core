@if(\Request::route()->getName() === 'listings.show')
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Related Listings',
        'mt' => isset($sponsored) ? 'mt-4' : '',
    ])
@elseif($listings->currentPage() === 1)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => $listings->total() . ' ' . str_plural('Job', $listings->total()) . ' Found',
    ])
@else
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Page ' . $listings->currentPage() . ' of ' . $listings->lastPage(),
    ])
@endif