<a href="{{ $listing->position_uri }}" class="btn {{ config('job-core.button_class') }} btn-block text-center{{ isset($class) ? ' ' . $class : '' }}" target="_blank">
    <i class="fa fa-external-link"></i> Apply Now
</a>
@if(isset($extra) && $extra === true)
    <small class="d-block text-muted text-center mt-1">
        <em>Published {{ $listing->publication_start_date->diffForHumans() }}</em>
    </small>
@endif