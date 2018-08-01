@include('job-core::partials.h-tag', [
    'tag' => 'h6',
    'title' => 'Refer-a-Friend',
    'mb' => 'mb-3',
])
<form method="POST" action="{{ route('referral.store') }}" aria-label="{{ __('Referral') }}" class="small">
    @csrf
    @captcha

    <input type="hidden" name="listing" value="{{ $request->has('listing') ? $request->listing }} : ''">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="from">Your Email</label>
                <input id="from" type="text" name="from" class="form-control{{ $errors->has('from') ? ' is-invalid' : '' }}" placeholder="Please enter your email" required="required">
                @if ($errors->has('from'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('from') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="to">Their Email</label>
                <input id="to" type="text" name="to" class="form-control{{ $errors->has('to') ? ' is-invalid' : '' }}" placeholder="Please enter their email" required="required">
                @if ($errors->has('to'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('to') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <input type="submit" class="btn btn-lg {{ config('job-core.button_class') }}" value="Email Job">
        </div>
    </div>
</form>
<br />