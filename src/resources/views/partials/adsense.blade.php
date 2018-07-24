@if(config('job-core.monetized') && empty($_GET) && substr(\Request::route()->getName(), 0, 5) !== 'pages')
    <div class="row d-none d-md-block">
        <div class="col">
            <Adsense
                data-ad-client="{{ config('job-core.google_ad_client') }}"
                data-ad-slot="{{ config('job-core.google_ad_slot') }} ">
            </Adsense>
        </div>
    </div>
@endif

1. {{ config('job-core.monetized') }}<br />
2. {{ empty($_GET) }}<br />
3. {{ substr(\Request::route()->getName(), 0, 5) !== 'pages' }}<br />