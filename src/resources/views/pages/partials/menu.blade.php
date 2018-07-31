@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Page Menu',
])
@include('job-core::partials.p-tag', [
    'text' => 'About Us',
    'link' => route('pages.about'),
    'pt' => 'pt-3',
    'pb' => '',
])
@include('job-core::partials.p-tag', [
    'text' => 'Advertise',
    'link' => route('pages.advertise'),
    'pt' => 'pt-2',
    'pb' => '',
])
@include('job-core::partials.p-tag', [
    'text' => 'Disclaimer',
    'link' => route('pages.disclaimer'),
    'pt' => 'pt-2',
    'pb' => '',
])
@include('job-core::partials.p-tag', [
    'text' => 'Privacy Policy',
    'link' => route('pages.privacy'),
    'pt' => 'pt-2',
    'pb' => '',
])
@include('job-core::partials.p-tag', [
    'text' => 'Terms of Use',
    'link' => route('pages.terms'),
    'pt' => 'pt-2',
    'pb' => 'pb-4',
])