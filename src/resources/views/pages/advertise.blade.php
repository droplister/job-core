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
                    Job seekers love {{ config('job-core.domain') }} for its hyper relevant job alerts that they can get sent for free to their email inbox. If you are intersted in advertising on {{ config('job-core.domain') }}, please <a href="{{ route('contact.create') }}">contact us</a>.
                </p>
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::pages.partials.menu')
            </div>
        </div>
    </div>
@endsection