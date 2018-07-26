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
    <span class="badge badge-pill bg-light align-text-bottom">
        {{ \Droplister\JobCore\App\Listing::listingFilter()->count() }}
    </span>
</a>