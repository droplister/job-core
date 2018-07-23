@include('partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Related Searches',
])
@foreach($children as $child)
    @include('partials.p-tag', [
        'text' => $child->value,
        'link' => isset($level) && $child->slug === $level->slug ? null : route('levels.show', ['level' => $child->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => ''
    ])
@endforeach
@include('partials.search-link')