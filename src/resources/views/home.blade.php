@extends('job-core::layouts.app')

@section('title', config('job-core.keyword') . ' - ' . config('job-core.domain'))
@section('description', config('job-core.keyword') . ' - ' . config('job-core.tagline'))

@section('content')
    <section class="jumbotron text-center mt-3 {{ config('job-core.body_class') }}">
        <div class="container">
            <h1 class="jumbotron-heading">{{ config('job-core.keyword') }}</h1>
            <p class="lead text-muted">{{ config('job-core.tagline') }}</p>
            <p>
                <a href="{{ route('search.index') }}" class="btn btn-lg btn-success my-2">
                    <i class="fa fa-search"></i>
                    Search
                </a>
                <a href="{{ route('locations.index') }}" class="btn btn-lg btn-primary my-2">
                    <i class="fa fa-map"></i>
                    Browse
                </a>
            </p>
            @guest
                <p class="lead text-muted small font-italic">
                    <a href="{{ route('login') }}">Login</a> or
                    <a href="{{ route('register') }}">Register</a>
                </p>
            @endguest
        </div>
    </section>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-3">
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => 'Popular Searches'
                ])     
                @foreach($locations as $location)
                    @include('job-core::partials.p-tag', [
                        'text' => $location->title,
                        'link' => route('locations.show', ['location' => $location->slug]),
                        'pt' => $loop->first ? 'pt-3' : 'pt-2',
                        'pb' => $loop->last ? 'pb-4' : '',
                    ])
                @endforeach
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => 'Browse Careers'
                ])     
                @foreach($careers as $career)
                    @include('job-core::partials.p-tag', [
                        'text' => $career->value,
                        'link' => route('careers.show', ['career' => $career->slug]),
                        'pt' => $loop->first ? 'pt-3' : 'pt-2',
                        'pb' => $loop->last ? 'pb-4' : '',
                    ])
                @endforeach
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => 'Federal Agencies'
                ])   
                @foreach($agencies as $agency)
                    @include('job-core::partials.p-tag', [
                        'text' => $agency->value,
                        'link' => route('agencies.show', ['agency' => $agency->slug]),
                        'pt' => $loop->first ? 'pt-3' : 'pt-2',
                        'pb' => $loop->last ? 'pb-4' : '',
                    ])
                @endforeach
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => 'Clearance Levels'
                ])  
                @foreach($clearances as $clearance)
                    @include('job-core::partials.p-tag', [
                        'text' => $clearance->value,
                        'link' => route('clearances.show', ['clearance' => $clearance->slug]),
                        'pt' => $loop->first ? 'pt-3' : 'pt-2',
                        'pb' => $loop->last ? 'pb-4' : '',
                    ])
                @endforeach
            </div>
        </div>
    </div>
@endsection
