<form method="POST" action="{{ route('contact.store') }}" aria-label="{{ __('Contact') }}">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input id="first_name" type="text" name="first_name" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="Please enter your first name" required="required">
                @if ($errors->has('first_name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input id="last_name" type="text" name="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="Please enter your last name" required="required">
                @if ($errors->has('last_name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Your Email</label>
                <input id="email" type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Please enter your email" required="required">
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="subject">Pick a subject</label>
                <select id="subject" name="subject" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" required="required">
                    <option value=""></option>
                    <option value="Advertising">Advertising</option>
                    <option value="Bugs &amp; Errors">Bugs &amp; Errors</option>
                    <option value="Press Inquiry">Press Inquiry</option>
                    <option value="Website Feedback">Website Feedback</option>
                    <option value="Other">Other</option>
                </select>
                @if ($errors->has('subject'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('subject') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="body">Your Message</label>
                <textarea id="body" name="body" class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" placeholder="Please enter your message here..." rows="4" required="required"></textarea>
                @if ($errors->has('body'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('body') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <input type="submit" class="btn btn-success btn-send" value="Send message">
        </div>
    </div>
</form>