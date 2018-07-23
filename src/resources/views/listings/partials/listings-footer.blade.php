@if(\Request::route()->getName() !== 'listings.show' && $listings->hasMorePages() || \Request::route()->getName() !== 'listings.show' && $listings->currentPage() > 1)
    <br />
    {!! $listings->links() !!}
@else
    <small class="d-block text-right mt-3">
        <a href="{{ route('alerts.index') }}">
            <i class="fa fa-bell-o"></i> Get Alerts
        </a>
    </small>
@endif
@if(\Request::route()->getName() !== 'listings.show')
    <br class="d-md-none" />
@endif