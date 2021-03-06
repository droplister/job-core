<div class="d-flex align-items-center p-3 my-3 rounded box-shadow {{ config('job-core.title_class') }}">
    <i class="fa {{ $fa }} fa-lg mt-3 mr-3 mb-3"></i>
    <div class="lh-100">
        <h1 class="h6 mb-0 lh-100">
            @if(isset($link))
                <a href="{{ $link }}" class="text-white d-block">
                    {{ $title }}
                </a>
            @else
                <span class="text-white d-block">
                    {{ $title }}
                </span>
            @endif
        </h1>
        @if(isset($subtitle))
            <h3 class="h6 mb-0 font-weight-normal">
                {{ $subtitle }}
            </h3>
        @endif
    </div>
</div>
@include('job-core::partials.adsense')