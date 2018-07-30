@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Narrow by Location',
])
@foreach($locations as $child)
    @include('job-core::partials.p-tag', [
        'text' => $child->title,
        'link' => $request->has('location') && $child->id === $request->location ? null : route($route, [
        	'location' => $child->id
        ], $request->except('location')),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => $loop->last ? 'pb-4' : '',
    ])
@endforeach
@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Narrow by Schedule',
])
@foreach($schedules as $child)
    @include('job-core::partials.p-tag', [
        'text' => $child->value,
        'link' => $request->has('schedule') && $child->code === $request->schedule ? null : route($route, [
        	'schedule' => $child->code,
        ], $request->except('schedule')),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => $loop->last ? 'pb-4' : '',
    ])
@endforeach
@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Narrow by Clearance',
])
@foreach($clearances as $child)
    @include('job-core::partials.p-tag', [
        'text' => $child->value,
        'link' => $request->has('clearance') && $child->id === $request->clearance ? null : route($route, [
        	'clearance' => $child->id
        ], $request->except('clearance')),
        'pt' => $loop->first ? 'pt-3' : 'pt-2',
        'pb' => '',
    ])
@endforeach
@include('job-core::partials.search-link')