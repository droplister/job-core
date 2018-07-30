@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Security Clearance'
])     
@foreach($clearances as $clearance)
    @include('job-core::partials.p-tag', [
        'text' => $clearance->value,
        'link' => route('clearances.show', ['clearance' => $clearance->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => $loop->last ? 'pb-4' : '',
    ])
@endforeach