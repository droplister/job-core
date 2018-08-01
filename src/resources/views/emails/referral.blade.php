@component('mail::message')
## {{ $from }} shared this {{ $listing->position_title }} job with you.

Find this job and more like it on {{ config('job-core.domain') }}.

@component('mail::button', ['url' => route('listings.show', ['listing' => $listing->slug])])
View This Job
@endcomponent

@endcomponent