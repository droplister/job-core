@extends('job-core::layouts.app')

@section('title', __('Register'))

@section('content')
<div class="row justify-content-center small mt-5">
    <div class="col-md-8">
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
        <div class="card">
            <div class="card-header">{{ __('Registration') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="newsletter" id="newsletter" {{ old('newsletter') ? 'checked' : '' }}>

                                <label class="form-check-label" for="newsletter">
                                    {{ __('Subscribe to ') }}
                                    <a href="route('pages.newsletter')">{{ config('job-core.keyword_root') }}</a>
                                    newsletter
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('I agree to the ') }}
                                    <a href="{{ route('pages.terms') }}">{{ __('Terms of Service') }}</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn {{ config('job-core.button_class') }}">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<p class="text-muted text-center small lh-135 py-4 mb-0">
    Already have an account?
    <a href="{{ route('login') }}" class="ml-1">
        <i class="fa fa-sign-in"></i>
        Sign in
    </a>
</p>
@endsection
