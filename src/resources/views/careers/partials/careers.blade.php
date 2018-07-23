@if(count($children))
    @include('partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Related Searches',
    ])
    @if($parent)
        @include('partials.p-tag', [
            'text' => $parent->value,
            'link' => route('careers.show', ['career' => $parent->slug]),
            'pt' => 'pt-3',
            'pb' => ''
        ])
    @endif
    @foreach($children as $child)
        @include('partials.p-tag', [
            'text' => $child->value,
            'link' => isset($career) && $child->slug === $career->slug ? null : route('careers.show', ['career' => $child->slug]),
            'pt' => $loop->first && ! $parent ? 'pt-3' : 'pt-2',
            'pb' => ''
        ])
    @endforeach
    @include('partials.search-link')
@endif