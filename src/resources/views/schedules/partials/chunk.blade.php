@include('partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Job Schedules'
])     
@foreach($schedules as $schedule)
    @include('partials.p-tag', [
        'text' => $schedule->value,
        'link' => route('schedules.show', ['schedule' => $schedule->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => $loop->last ? 'pb-4' : '',
    ])
@endforeach