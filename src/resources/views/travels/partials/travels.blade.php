@include('partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Related Searches',
])
@foreach($children as $child)
    @include('partials.p-tag', [
        'text' => $child->value,
        'link' => isset($travel) && $child->slug === $travel->slug ? null : route('travels.show', ['travel' => $child->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => ''
    ])
@endforeach
@include('partials.search-link')