@if($listing->who_may_apply)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Who May Apply'
    ])
    @include('job-core::partials.p-tag', [
        'text' => $listing->who_may_apply
    ])
@endif