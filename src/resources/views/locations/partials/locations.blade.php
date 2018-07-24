@if(count($children))
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Related Searches',
    ])
    @if($parent && $parent->type !== 'country')
        @include('job-core::partials.p-tag', [
            'text' => 'United States',
            'link' => route('locations.index'),
            'pt' => 'pt-3',
            'pb' => '',
        ])
        @include('job-core::partials.p-tag', [
            'text' => $parent->name,
            'link' => route('locations.show', ['location' => $parent->slug]),
            'pt' => 'pt-2',
            'pb' => '',
        ])
    @elseif($parent && $parent->type === 'country')
        @include('job-core::partials.p-tag', [
            'text' => 'United States',
            'link' => route('locations.index'),
            'pt' => 'pt-3',
            'pb' => '',
        ])
        @include('job-core::partials.p-tag', [
            'text' => $location->name,
            'pt' => 'pt-2',
            'pb' => '',
        ])
    @endif
    @foreach($children as $child)
        @include('job-core::partials.p-tag', [
            'text' => $child->name,
            'link' => $child->slug === $location->slug ? null : route('locations.show', ['location' => $child->slug]),
            'pt' => $loop->first && ! $parent ? 'pt-3' : 'pt-2',
            'pb' => ''
        ])
    @endforeach
    @include('job-core::partials.search-link')
@endif