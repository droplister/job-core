<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (! empty($_GET)) { ?>
    <meta name="robots" content="noindex,follow">
<?php } ?>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="{{ config('job-core.body_class') }}">
    <div id="app">
        <nav class="navbar navbar-expand-lg fixed-top {{ config('job-core.nav_class') }}">
            <a class="navbar-brand mr-auto mr-lg-3" href="{{ route('home.index') }}">
                <i class="fa {{ config('job-core.icon_class') }} mr-2"></i>
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item d-none d-md-inline-block">
                        <a class="nav-link" href="{{ route('home.index') }}">
                            {{ __('Home') }}
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="{{ route('search.index') }}">
                            {{ __('Search') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('locations.index') }}">
                            {{ __('Browse') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agencies.index') }}">
                            {{ __('Agencies') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('careers.index') }}">
                            {{ __('Careers') }}
                        </a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link mr-3" href="{{ route('login') }}">
                                <i class="fa fa-sign-in"></i>
                                {{ __('Login') }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link mr-3" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
                <form form method="GET" action="{{ route('search.index') }}" aria-label="{{ __('Search') }}"class="form-inline my-2 my-lg-0 d-none d-md-inline-block">
                    <input name="q" id="q" class="form-control mr-sm-2" type="text" placeholder="Enter a Keyword" aria-label="Search" minlength="3" value="{{ isset($_GET['q']) ? $request->q : '' }}" required>
                    <button class="btn my-2 my-sm-0 {{ config('job-core.search_class') }}" type="submit">
                        <i class="fa fa-search"></i>
                        Search
                    </button>
                </form>
            </div>
        </nav>

        <div class="nav-scroller box-shadow {{ config('job-core.subnav_class') }}">
            <nav class="nav nav-underline">
                @include('job-core::partials.subnav-left')
                @include('job-core::partials.subnav-right')
            </nav>
        </div>

        <main role="main" class="container">
            @yield('content')
        </main>

        <footer role="footer" class="container">
            <div class="row text-center my-3">
                <div class="col">
                    <p class="text-muted pt-3 pb-0 mb-0 small lh-135">
                        <a href="{{ route('pages.about') }}" class="mr-2">About</a>
                        <a href="{{ route('pages.disclaimer') }}" class="mr-2">Disclaimer</a>
                        <a href="{{ route('pages.privacy') }}" class="mr-2">Privacy</a>
                        <a href="{{ route('pages.terms') }}">Terms</a>
                    </p>
                    <p class="text-muted pt-1 pb-3 mb-0 small lh-135">
                        Family Media LLC &copy; {{ date('Y') }}
                    </p>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>
