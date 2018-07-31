@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Other Methods',
])
@include('job-core::partials.p-tag', [
    'text' => 'We prefer to be contacted by email, but we can also be reached at this address:',
    'pt' => 'pt-3',
    'pb' => '',
])
@include('job-core::partials.p-tag', [
    'text' => 'Agent of ' . config('job-core.domain') . ', 204-17 Hillside Ave, Suite 311, Hollis, NY 11432.',
    'pt' => 'pt-2',
])