@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Menu',
])
@include('job-core::partials.p-tag', [
    'text' => 'About',
    'link' => \Request::route()->getName() !== 'pages.about' ? route('pages.about') : null,
    'pt' => 'pt-3',
    'pb' => '',
])
@include('job-core::partials.p-tag', [
    'text' => 'Advertise',
    'link' => \Request::route()->getName() !== 'pages.advertise' ? route('pages.advertise') : null,
    'pt' => 'pt-2',
    'pb' => '',
])
@include('job-core::partials.p-tag', [
    'text' => 'Disclaimer',
    'link' => \Request::route()->getName() !== 'pages.disclaimer' ? route('pages.disclaimer') : null,
    'pt' => 'pt-2',
    'pb' => '',
])
@include('job-core::partials.p-tag', [
    'text' => 'Privacy Policy',
    'link' => \Request::route()->getName() !== 'pages.privacy' ? route('pages.privacy') : null,
    'pt' => 'pt-2',
    'pb' => '',
])
@include('job-core::partials.p-tag', [
    'text' => 'Terms of Use',
    'link' => \Request::route()->getName() !== 'pages.terms' ? route('pages.terms') : null,
    'pt' => 'pt-2',
    'pb' => 'pb-4',
])