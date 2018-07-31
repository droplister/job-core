@if(auth()->check() && count($listings) === 0 || isset($sponsored))
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Featured Jobs',
    ])
    @foreach($sponsored->all() as $job)
        @include('job-core::listings.partials.sponsored-listing')
        @if($loop->iteration == config('job-core.max_sponsored')) @break @endif
    @endforeach
@endif