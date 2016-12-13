<div id="signin" class="tab-pane fade active in">
    <form method="post" action="{{ route('postLogin') }}">
        <fieldset>
            <!-- Sign In Form -->
            <!-- Text input-->
            <div class="control-group">
                <label for="useremail" class="control-label">Email:</label>
                <div class="controls">
                    <input type="email" placeholder="johndoe@company.io" class="form-control" name="loginemail" id="useremail" value="{{ old('loginemail') }}">
                </div>
                @if($errors->any())
                <div id="useremailValidation" style="color:red">{{ $errors->first('loginemail') }}</div>
                @endif
            </div>
            <!-- Password input-->
            <div class="control-group">
                <label for="passwordlogin" class="control-label">Password:</label>
                <div class="controls">
                    <input type="password" placeholder="itsasecret" class="form-control" name="loginpassword" id="passwordlogin">
                </div>
                @if($errors->any())
                <div id="passwordloginValidation" style="color:red">{{ $errors->first('loginpassword') }}</div>
                @endif
            </div>
            <!-- Multiple Checkboxes (inline) -->
            <div class="control-group">
                <div class="controls">
                    <label for="remember_me" class="checkbox inline">
                        <input type="checkbox" value="true" id="remember_me" name="remember"> Remember me
                    </label>
                </div>
            </div>
            <!-- Button -->
            <div class="control-group">
                <div class="controls">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <button class="btn btn-primary" style="background:#284666; color: #fff;" type="submit" id="signinButton">Sign In</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>