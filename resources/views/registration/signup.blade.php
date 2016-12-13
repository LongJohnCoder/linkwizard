<div id="signup" class="tab-pane fade">
    <form method="post" action="{{ route('postRegister') }}" onsubmit="return validateHumanity();">
        <fieldset>
            <!-- Sign Up Form -->
            <!-- Text input-->
            <div class="control-group">
                <label for="Name" class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" placeholder="John Doe" class="form-control" name="name" id="Name" value="{{ old('name') }}">
                </div>
                @if($errors->any())
                <div id="NameValidation" style="color:red">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <!-- Text input-->
            <div class="control-group">
                <label for="Email" class="control-label">Email:</label>
                <div class="controls">
                    <input type="email" placeholder="johndoe@company.io" class="form-control" name="email" id="Email" value="{{ old('email') }}">
                </div>
                @if($errors->any())
                <div id="EmailValidation" style="color:red">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <!-- Password input-->
            <div class="control-group">
                <label for="password" class="control-label">Password:</label>
                <div class="controls">
                    <input type="password" placeholder="itsasecret" class="form-control" name="password" id="password">
                </div>
                @if($errors->any())
                <div id="passwordValidation" style="color:red">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <!-- Text input-->
            <div class="control-group">
                <label for="password_confirmation" class="control-label">Confirm Password:</label>
                <div class="controls">
                    <input type="password" placeholder="itsasecret" name="password_confirmation" class="form-control" id="password_confirmation">
                </div>
                @if($errors->any())
                <div id="password_confirmationValidation" style="color:red">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>
            <!-- Multiple Radios (inline) -->
            <div class="control-group">
                <label for="humancheck" class="control-label">Humanity Check:</label>
                <div class="controls" id="reCAPTCHA_div">
                    {!! Recaptcha::render() !!}
                </div>
                @if($errors->any())
                <div id="humancheckValidation" style="color:red">{{ $errors->first('g-recaptcha-response') }}</div>
                @endif
            </div>
            <!-- Button -->
            <div class="control-group">
                <div class="controls">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <button class="btn btn-primary" type="submit" style="background:#284666; color: #fff;" id="confirmsignup">Sign Up</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>