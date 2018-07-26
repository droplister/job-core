<div class="row justify-content-center small mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h6 class="border-bottom border-gray pb-2 mb-3">
                    Search by Keyword
                </h6>
                <form method="GET" action="{{ route('search.index') }}" aria-label="{{ __('Search') }}">
                    <div class="form-group">
                        <input id="q" type="text" class="form-control{{ $errors->has('q') || $request->has('q') ? ' is-invalid' : '' }}" name="q" minlength="3" value="{{ $request->has('q') ? $request->q : old('q') }}" placeholder="Enter a Keyword" required autofocus>

                        @if($errors->has('q'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('q') }}</strong>
                            </span>
                        @elseif($request->has('q'))
                            <span class="invalid-feedback" role="alert">
                                <strong>No Search Results Found</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-lg btn-success">
                            <i class="fa fa-search"></i>
                            {{ __('Search') }}
                        </button>
                        @if($request->has('q'))
                        <a class="btn btn-link" href="{{ route('locations.index') }}">
                            <i class="fa fa-map"></i>
                            Browse by State
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>