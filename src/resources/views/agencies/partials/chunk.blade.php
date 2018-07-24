@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => $agency->value,
    'link' => route('agencies.show', ['agency' => $agency->slug]),
    'pt' => $loop->first ? '' : 'pt-4',
    'pb' => 'pb-2'
])
@foreach($agency->related()->get() as $child)
    @include('job-core::partials.p-tag', [
        'text' => $child->value,
        'link' => route('agencies.show', ['agency' => $child->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => 'pb-0',
    ])
@endforeach