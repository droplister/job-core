@extends('job-core::layouts.app')

@section('title', config('job-core.keyword_root') . ' Newsletter')

@section('content')
    <section class="jumbotron text-center mt-3 {{ config('job-core.body_class') }}">
        <div class="container">
            <h1 class="jumbotron-heading">
                <i class="fa fa-envelope"></i>
                Newsletter
            </h1>
            <p class="lead text-muted">
                Best {{ strtolower(str_singular(config('job-core.keyword_root'))) }} jobs.
            </p>
            <p class="lead text-muted mb-1">
                <a href="{{ route('alerts.index') }}" class="btn btn-lg {{ config('job-core.button_class') }}">
                    <i class="fa fa-edit mr-2"></i>
                    Register for FREE
                </a>
            </p>
            <p class="lead text-muted small font-italic">
                No spam & one-click unsubscribe
            </p>
        </div>
    </section>
@endsection