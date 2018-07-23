<p class="text-muted small lh-135{{ isset($pt) ? ' ' . $pt : ' pt-3' }}{{ isset($pb) ? ' '. $pb : ' pb-4' }}{{ isset($mt) ? ' ' . $mt : '' }}{{ isset($mb) ? ' ' . $mb : ' mb-0' }}">
    @if(isset($link))
        <a href="{{ $link }}">
            {!! $text !!}
        </a>
    @else
        {!! $text !!}
    @endif
</p>