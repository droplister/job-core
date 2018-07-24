@if($listing->relatedLocations()->exists())
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Location'
    ])
    @foreach($listing->relatedLocations()->get() as $location)
        @include('job-core::partials.p-tag', [
            'text' => $location->title,
            'link' => route('locations.show', ['location' => $location->slug]),
            'pt' => $loop->first ? 'pt-3' : 'pt-2',
            'pb' => ''
        ])
    @endforeach
    @if($listing->relatedLocations()->count() > config('job-core.max_relations'))
        @include('job-core::partials.p-tag', [
            'text' => 'And ' . $listing->locations()->isCity()->count() . ' more...',
            'pt' => 'pt-2',
            'pb' => '',
        ])
    @endif
@endif