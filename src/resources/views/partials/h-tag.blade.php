<{{ $tag }} class="border-bottom border-gray{{ isset($pt) ? ' ' . $pt : '' }}{{ isset($pb) ? ' ' . $pb : ' pb-2' }}{{ isset($mt) ? ' ' . $mt : '' }}{{ isset($mb) ? ' ' . $mb : ' mb-0' }}">
    @if(isset($link))
        <a href="{{ $link }}" class="text-dark">
            {{ $title }}
        </a>
    @else
        {{ $title }}
    @endif
</{{ $tag }}>