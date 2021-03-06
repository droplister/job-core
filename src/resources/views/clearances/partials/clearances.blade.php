@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Related Searches',
])
@foreach($children as $child)
    @include('job-core::partials.p-tag', [
        'text' => $child->value,
        'link' => isset($clearance) && $child->slug === $clearance->slug ? null : route('clearances.show', ['clearance' => $child->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => ''
    ])
@endforeach
@include('job-core::partials.search-link')