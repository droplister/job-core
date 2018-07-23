@if($listing->who_may_apply)
    @include('partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Who May Apply'
    ])
    @include('partials.p-tag', [
        'text' => $listing->who_may_apply
    ])
@endif