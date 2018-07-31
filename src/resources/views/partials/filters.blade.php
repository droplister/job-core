@if($show_filters)
    <br class="d-md-none" />
@endif

@include('job-core::partials.filter', [
	'children' => $careers,
	'parameter' => 'career'
])

@include('job-core::partials.filter', [
	'children' => $agencies,
	'parameter' => 'agency'
])

@include('job-core::partials.filter', [
	'children' => $locations,
	'parameter' => 'location'
])

@include('job-core::partials.filter', [
	'children' => $schedules,
	'parameter' => 'schedule'
])

@include('job-core::partials.filter', [
	'children' => $travels,
	'parameter' => 'travel'
])

@include('job-core::partials.filter', [
	'children' => $clearances,
	'parameter' => 'clearance'
])

@if(! empty($_GET))
	<small class="d-block text-right mt-3">
	    <a href="{{ route($route) }}">
	        <i class="fa fa-refresh"></i> Reset
	    </a>
	</small>
@endif