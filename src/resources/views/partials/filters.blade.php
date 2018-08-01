@if($show_filters)
    <br class="d-md-none" />
@endif

@if(count($days_ago) > 0)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Narrow by Age',
    ])
    @foreach($days_ago as $days)
        @if($request->has('days') && $days === $request->days)
            @include('job-core::partials.p-tag', [
                'text' => $days === 1 ? '24 hours ago' : $days . ' days ago',
                'pt' => $loop->first ? 'pt-3' : 'pt-2',
                'pb' => $loop->last ? 'pb-4' : '',
            ])
        @else
            @include('job-core::partials.p-tag', [
                'text' => $days === 1 ? '24 hours ago' : $days . ' days ago',
                'link' => route($route, ['days' => $days] + $request->except('days')),
                'pt' => $loop->first ? 'pt-3' : 'pt-2',
                'pb' => $loop->last ? 'pb-4' : '',
            ])
        @endif
    @endforeach
@endif

@include('job-core::partials.filter', [
	'children' => $schedules,
	'parameter' => 'schedule'
])

@include('job-core::partials.filter', [
	'children' => $paths,
	'parameter' => 'path'
])

@include('job-core::partials.filter', [
	'children' => $travels,
	'parameter' => 'travel'
])

@if(! empty($_GET) && $show_filters)
	<small class="d-block text-right mt-3">
	    <a href="{{ route($route) }}">
	        <i class="fa fa-refresh"></i> Reset
	    </a>
	</small>
@endif