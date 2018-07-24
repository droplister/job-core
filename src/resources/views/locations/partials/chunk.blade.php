@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => $location->name,
    'link' => route('locations.show', ['location' => $location->slug]),
    'pt' => $loop->first ? '' : 'pt-4',
    'pb' => 'pb-2'
])
@foreach($location->related()->get() as $child)
    @include('job-core::partials.p-tag', [
        'text' => $child->name,
        'link' => route('locations.show', ['location' => $child->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => 'pb-0',
    ])
@endforeach