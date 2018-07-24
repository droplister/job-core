@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Hiring Paths'
])     
@foreach($paths as $path)
    @include('job-core::partials.p-tag', [
        'text' => $path->value,
        'link' => route('paths.show', ['path' => $path->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => $loop->last ? 'pb-4' : '',
    ])
@endforeach