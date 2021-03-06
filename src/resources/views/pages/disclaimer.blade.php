@extends('job-core::layouts.app')

@section('title', 'Disclaimer')
@section('description', 'This website is not endorsed by, or associated with, any government agency. Family Media publishes free internet resources for niche audiences online.')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-info-circle',
        'title' => 'Disclaimer',
        'link' => route('pages.disclaimer')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => 'You Should Know',
                    'mb' => 'mb-3',
                ])
                <p class="text-muted small lh-135">1. This website is not endorsed by, or associated with, any government agency. {{ config('job-core.domain') }} is a privately owned website run by <a href="https://familymediallc.com/">Family Media LLC</a>. Family Media publishes free internet resources for niche audiences online. If you have any questions, please <a href="{{ route('contact.create') }}">contact us</a>.</p>
                <p class="text-muted small lh-135">2. The listings on our website come from <a href="https://www.usajobs.gov/" target="_blank">USAJobs.gov</a> and other job boards, like <a href="https://juju.com/" target="_blank">JuJu.com</a>. We try our best to offer you the most up-to-date jobs, but we cannot guarantee the accuracy of any information posted on {{ config('job-core.domain') }}.</p>
                <p class="text-muted small lh-135">3. This website generates income through banner advertisements and affiliate links. Third party vendors, including Google, use cookies to serve ads based on a user's prior visits to our website.</p>
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::pages.partials.menu')
            </div>
        </div>
    </div>
@endsection