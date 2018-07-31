@extends('job-core::layouts.app')

@section('content')
    <section class="jumbotron text-center mt-3 {{ config('job-core.body_class') }}">
        <div class="container col-md-6">
            <h1 class="jumbotron-heading">
                <i class="fa fa-bell"></i>
                Email Alerts
            </h1>
            <p class="lead text-muted">
        	    Thank you for your interest in our job alerts feature. It is currently under going maintenance and will be available again soon.
        	</p>
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
        </div>
    </section>
@endsection