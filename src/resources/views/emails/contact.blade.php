@component('mail::layout')
	@slot('header')
	    @component('mail::header', ['url' => config('app.url')])
	        {{ config('job-core.domain') }}
	    @endcomponent
	@endslot

	# {{ $first_name }} {{ $last_name }} said,

	{{ $body }}
@endcomponent