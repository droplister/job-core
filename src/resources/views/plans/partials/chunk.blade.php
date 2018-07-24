@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Pay Plans'
])     
@foreach($plans as $plan)
    @include('job-core::partials.p-tag', [
        'text' => $plan->value,
        'link' => route('plans.show', ['plan' => $plan->slug]),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => $loop->last ? 'pb-4' : '',
    ])
@endforeach