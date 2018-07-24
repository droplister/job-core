<div class="nav-scroller box-shadow {{ config('job-core.subnav_class') }}">
    <nav class="nav nav-underline">
        <a class="nav-link active" href="{{ route('alerts.index') }}">
            <i class="fa fa-bell"></i>
            @guest
                Get Alerts
            @else
                My Alerts
            @endguest
        </a>
        <a class="nav-link" href="{{ route('listings.index') }}">
            Latest Jobs
        </a>
        <a class="nav-link ml-auto mr-0 d-none d-md-inline-block" href="{{ route('pages.advertise') }}">
            Advertise
        </a>
        <a class="nav-link d-none d-md-inline-block" href="{{ route('affiliate.index') }}" target="_blank">
            <i class="fa fa-book"></i>
            Book Store
        </a>
        <a class="nav-link d-none d-md-inline-block" href="{{ route('contact.create') }}">
            <i class="fa fa-envelope-o"></i>
            Contact Us
        </a>
    </nav>
</div>