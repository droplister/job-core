<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
@if(! empty($_GET))
    <meta name="robots" content="noindex,follow">
@endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-38718705-57"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '{{ config('job-core.google_analytics') }}');
    </script>
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

            <div class="navbar-collapse offcanvas-collapse {{ config('job-core.nav_class') }}">
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route('home.index') }}" id="dropdown-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Explore
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-menu">
                            @if(config('job-core.domain') !== 'FedHire.com')
                                <a class="dropdown-item" href="https://fedhire.com/">
                                    <i class="fa fa-university text-primary"></i>
                                    FedHire.com
                                </a>
                            @endif
                            @if(config('job-core.domain') !== 'GovAdmin.com')
                                <a class="dropdown-item" href="https://govadmin.com/">
                                    <i class="fa fa-briefcase text-danger"></i>
                                    GovAdmin.com
                                </a>
                            @endif
                            @if(config('job-core.domain') !== 'SecurityClearance.io')
                                <a class="dropdown-item" href="https://securityclearance.io/">
                                    <i class="fa fa-address-card text-warning"></i>
                                    SecurityClearance.io
                                </a>
                            @endif
                            @if(config('job-core.domain') !== 'MilitaryBaseJobs.com')
                                <a class="dropdown-item" href="https://militarybasejobs.com/">
                                    <i class="fa fa-globe text-info"></i>
                                    MilitaryBaseJobs.com
                                </a>
                            @endif
                            @if(config('job-core.domain') !== 'GovernmentInternships.org')
                                <a class="dropdown-item" href="https://governmentinternships.org/">
                                    <i class="fa fa-university text-success"></i>
                                    GovernmentInternships.org
                                </a>
                            @endif
                        </div>
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
                        <a href="{{ route('pages.advertise') }}" class="mr-2">Advertise</a>
                        <a href="{{ route('pages.disclaimer') }}" class="mr-2">Disclaimer</a>
                        <a href="{{ route('pages.privacy') }}" class="mr-2">Privacy</a>
                        <a href="{{ route('pages.terms') }}">Terms</a>
                        @if(config('job-core.twitter'))
                            <a href="{{ config('job-core.twitter') }}" class="ml-2">
                                <i class="fa fa-twitter"></i>
                            </a>
                        @endif
                        @if(config('job-core.medium'))
                            <a href="{{ config('job-core.medium') }}" class="ml-2">
                                <i class="fa fa-medium"></i>
                            </a>
                        @endif
                    </p>
                    <p class="text-muted pt-1 pb-3 mb-0 small lh-135">
                        <a href="https://familymediallc.com/" class="text-muted">Family Media LLC</a>
                        &copy; {{ date('Y') }}
                    </p>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>
