@if(count($careers) + count($agencies) + count($locations) + count($schedules) + count($clearances) > 0)
    <br class="d-md-none" />
@endif
@if(count($careers) > 0)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Narrow by Career',
    ])
    @foreach($careers as $child)
        @include('job-core::partials.p-tag', [
            'text' => $child->value,
            'link' => $request->has('career') && $child->id === (int) $request->career ? null : route($route, [
                'career' => $child->id
            ] + $request->except('career')),
            'pt' => $loop->first ? 'pt-3' : 'pt-2',
            'pb' => $loop->last ? 'pb-4' : '',
        ])
    @endforeach
@endif
@if(count($agencies) > 0)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Narrow by Agency',
    ])
    @foreach($agencies as $child)
        @include('job-core::partials.p-tag', [
            'text' => $child->value,
            'link' => $request->has('agency') && $child->id === (int) $request->agency ? null : route($route, [
                'agency' => $child->id
            ] + $request->except('agency')),
            'pt' => $loop->first ? 'pt-3' : 'pt-2',
            'pb' => $loop->last ? 'pb-4' : '',
        ])
    @endforeach
@endif
@if(count($locations) > 0)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Narrow by Location',
    ])
    @foreach($locations as $child)
        @include('job-core::partials.p-tag', [
            'text' => $child->title,
            'link' => $request->has('location') && $child->id === (int) $request->location ? null : route($route, [
            	'location' => $child->id
            ] + $request->except('location')),
            'pt' => $loop->first ? 'pt-3' : 'pt-2',
            'pb' => $loop->last ? 'pb-4' : '',
        ])
    @endforeach
@endif
@if(count($schedules) > 0)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Narrow by Schedule',
    ])
    @foreach($schedules as $child)
        @include('job-core::partials.p-tag', [
            'text' => $child->value,
            'link' => $request->has('schedule') && $child->code === $request->schedule ? null : route($route, [
            	'schedule' => $child->code,
            ] + $request->except('schedule')),
            'pt' => $loop->first ? 'pt-3' : 'pt-2',
            'pb' => $loop->last ? 'pb-4' : '',
        ])
    @endforeach
@endif
@if(count($clearances) > 0)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Narrow by Clearance',
    ])
    @foreach($clearances as $child)
        @include('job-core::partials.p-tag', [
            'text' => $child->value,
            'link' => $request->has('clearance') && $child->id === (int) $request->clearance ? null : route($route, [
            	'clearance' => $child->id
            ] + $request->except('clearance')),
            'pt' => $loop->first ? 'pt-3' : 'pt-2',
            'pb' => '',
        ])
    @endforeach
@endif
@include('job-core::partials.search-link')