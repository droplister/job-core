@guest
	@if(config('job-core.monetized') && empty($_GET) && substr(\Request::route()->getName(), 0, 5) !== 'pages')
	    <div class="row {{ isset($class) ? $class : 'd-none d-md-block' }}">
	        <div class="col">
	            <Adsense
	                data-ad-client="{{ config('job-core.google_ad_client') }}"
	                data-ad-slot="{{ config('job-core.google_ad_slot') }}">
	            </Adsense>
	        </div>
	    </div>
	@endif
@endguest