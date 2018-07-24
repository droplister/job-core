@extends('job-core::layouts.app')

@section('title', str_singular(config('job-core.keyword')) . ' Alerts')

@section('content')
    @if(count($alerts) === 0)
    <section class="jumbotron text-center mt-3 {{ config('job-core.body_class') }}">
        <div class="container">
            <h1 class="jumbotron-heading">
                <i class="fa fa-bell"></i>
                Email Alerts
            </h1>
            <p class="lead text-muted">Get instantly notified of new jobs.</p>
            <p class="lead text-muted small"><em>(ad free experience)</em></p>
        </div>
    </section>
    @endif
    @include('job-core::partials.title', [
        'fa' => 'fa-bell',
        'title' => 'Alerts',
        'link' => route('alerts.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-md-9">
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => 'My Alerts',
                ])
                @include('job-core::partials.resources')
            </div>
            <div class="col-md-3">
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => 'Profile',
                ])
                @include('job-core::partials.p-tag', [
                    'text' => $user->name,
                    'pt' => 'pt-3',
                    'pb' => '',
                ])
                @include('job-core::partials.p-tag', [
                    'text' => $user->email,
                    'pt' => '',
                    'pb' => '',
                ])
                @include('job-core::partials.p-tag', [
                    'text' => 'Joined: ' . $user->created_at->toDateString(),
                    'pt' => '',
                    'pb' => 'pb-4',
                ])
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection