@include('partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Security Clearance'
])     
@foreach($levels as $level)
    @include('partials.p-tag', [
        'text' => $level->value,
        'link' => route('levels.show', ['level' => $level->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => $loop->last ? 'pb-4' : '',
    ])
@endforeach