@include('partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Narrow by Schedule',
])
@foreach($schedules as $child)
    @include('partials.p-tag', [
        'text' => $child->value,
        'link' => $request->has('s') && $child->slug === $request->s ? null : route('search.index', ['q' => $request->q, 's' => $child->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => $loop->last ? 'pb-4' : '',
    ])
@endforeach
@include('partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Narrow by Clearance',
])
@foreach($levels as $child)
    @include('partials.p-tag', [
        'text' => $child->value,
        'link' => $request->has('l') && $child->slug === $request->l ? null : route('search.index', ['q' => $request->q, 'l' => $child->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => '',
    ])
@endforeach
@include('partials.search-link')