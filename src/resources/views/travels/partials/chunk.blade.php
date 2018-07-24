@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Percent Travel'
])     
@foreach($travels as $travel)
    @include('job-core::partials.p-tag', [
        'text' => $travel->value,
        'link' => route('travels.show', ['travel' => $travel->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => $loop->last ? 'pb-4' : '',
    ])
@endforeach