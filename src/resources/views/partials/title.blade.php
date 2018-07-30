<div class="d-flex align-items-center p-3 my-3 rounded box-shadow {{ config('job-core.title_class') }}">
    <i class="fa {{ $fa }} fa-lg mt-3 mr-3 mb-3"></i>
    <div class="lh-100">
        @if(isset($link))
            <h1 class="h6 mb-0 lh-100">
                <a href="{{ $link }}" class="text-white">
                    {{ $title }}
                </a>
            </h1>
        @else
            <h1 class="h6 mb-0 text-white lh-100">
                {{ $title }}
            </h1>
        @endif
        @if(isset($subtitle))
            <small>{{ $subtitle }}</small>
        @endif
    </div>
</div>
@include('job-core::partials.adsense')