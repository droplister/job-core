@extends('job-core::layouts.app')

@section('title', 'Advertise')
@section('description', 'Are you recruiting for or marketing ' . strtolower(config('job-core.keyword')) . '? Get in touch with our ad placement experts today.')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-info-circle',
        'title' => 'Advertise',
        'link' => route('pages.advertise')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => config('job-core.domain'),
                    'mb' => 'mb-3',
                ])
                <p class="text-muted small lh-135">
                    Job seekers love {{ config('job-core.domain') }} for its hyper-relevant search tools. They can subscribe for free to get new jobs sent to their inbox. Recruiters love us too! Whether you're a recruiter or a third-party ad agency, we offer a wide range of creative marketing opportunities. If you are interested in advertising on {{ config('job-core.domain') }}, please <a href="{{ route('contact.create') }}">contact us</a>.
                </p>
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => 'Research',
                    'mt' => 'mt-4',
                ])
                <p class="text-muted small lh-135 pt-3 mb-0">
                    "62% of candidates listed career sites as a top channel for researching new job opportunities."
                </p>
                <p class="text-muted small lh-135 pt-2 mb-0">
                    "HR teams are 2x more likely to recruit faster using data-driven recruiting."
                </p>
                <p class="text-muted small lh-135 pt-2 pb-2 mb-0">
                    Source: <a href="https://www.talentlyft.com/en/blog/article/114/10-recruiting-trends-in-2018-infographic" target="_blank">10 Recruiting Trends in 2018 (Infographic)</a>
                </p>
                <br class="d-md-none" />
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::pages.partials.menu')
            </div>
        </div>
    </div>
@endsection