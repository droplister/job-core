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
