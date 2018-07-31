@component('mail::layout')
	@slot('header')
	    @component('mail::header', ['url' => config('app.url')])
	        {{ config('job-core.domain') }}
	    @endcomponent
	@endslot

	# {{ $first_name }} {{ $last_name }} said,

	{{ $body }}

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} Family Media LLC. All rights reserved.
        @endcomponent
    @endslot
@endcomponent