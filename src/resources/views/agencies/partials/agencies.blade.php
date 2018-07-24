@if(count($children))
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Related Searches',
    ])
    @if($parent)
        @include('job-core::partials.p-tag', [
            'text' => $parent->value,
            'link' => route('agencies.show', ['agency' => $parent->slug]),
            'pt' => 'pt-3',
            'pb' => ''
        ])
    @endif
    @foreach($children as $child)
        @include('job-core::partials.p-tag', [
            'text' => $child->value,
            'link' => isset($agency) && $child->slug === $agency->slug ? null : route('agencies.show', ['agency' => $child->slug]),
            'pt' => $loop->first && ! $parent ? 'pt-3' : 'pt-2',
            'pb' => ''
        ])
    @endforeach
    @include('job-core::partials.search-link')
@endif