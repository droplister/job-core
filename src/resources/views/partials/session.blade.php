@if(session('warning'))
    <div class="alert alert-warning my-3" role="alert">
        {{ session('warning') }}
    </div>
@elseif(session('success'))
    <div class="alert alert-success my-3" role="alert">
        {{ session('success') }}
    </div>
@endif