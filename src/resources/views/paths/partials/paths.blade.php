@include('partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Related Searches',
])
@foreach($children as $child)
    @include('partials.p-tag', [
        'text' => $child->value,
        'link' => isset($path) && $child->slug === $path->slug ? null : route('paths.show', ['path' => $child->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => ''
    ])
@endforeach
@include('partials.search-link')