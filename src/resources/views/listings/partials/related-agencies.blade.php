@if($listing->relatedAgencies()->exists())
    @include('partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Agency'
    ])
    @foreach($listing->relatedAgencies()->get() as $agency)
        @include('partials.p-tag', [
            'text' => $agency->value,
            'link' => route('agencies.show', ['agency' => $agency->slug]),
            'pt' => $loop->first ? 'pt-3' : 'pt-2',
            'pb' => $loop->last && $listing->relatedLocations()->count() ? 'pb-4' : ''
        ])
    @endforeach
@endif