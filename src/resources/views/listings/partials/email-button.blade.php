<a href="#" class="btn {{ str_replace('btn-', 'btn-outline-', config('job-core.button_class')) }} btn-block text-center{{ isset($class) ? ' ' . $class : '' }}">
    <i class="fa fa-envelope-o"></i> Email Job
</a>
@if(isset($extra) && $extra === true)
    <small class="d-block text-muted text-center mt-1">
        <em>Send link via email</em>
    </small>
@endif