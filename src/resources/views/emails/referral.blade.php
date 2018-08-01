@component('mail::message')
## {{ $sender }} shared this {{ $listing->position_title }} job with you from {{ config('job-core.domain') }}.

{{ $listing->subtitle }}

@component('mail::button', ['url' => route('listings.show', ['listing' => $listing->slug])])
View This Job
@endcomponent

Find this job and more like it on our website.

Thank you,
{{ config('job-core.domain') }}

@endcomponent