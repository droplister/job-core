@include('partials.h-tag', [
    'tag' => 'h6',
    'title' => $chunk[0]->job_family,
    'pt' => $loop->first ? '' : 'pt-4',
    'pb' => 'pb-2'
])
@foreach($chunk as $career)
    @include('partials.p-tag', [
        'text' => $career->value,
        'link' => route('careers.show', ['career' => $career->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => 'pb-0',
    ])
@endforeach