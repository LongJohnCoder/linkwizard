<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="login_btn" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
	        <h1>sign in</h1>
	        <form method="post" action="{{ route('postLogin') }}">
	        	<div class="form-group"> 
	        		@if($errors->any())
	                	<div id="useremailValidation" style="color:red">{{ $errors->first('loginemail') }}</div>
	                @endif
	        		<input type="email" placeholder="johndoe@company.io" class="form-control" name="loginemail" id="useremail" value="{{ old('loginemail') }}">
		        	<label>email</label>
	        	</div>
	        	<div class="form-group"> 
	        		@if($errors->any())
	                	<div id="passwordloginValidation" style="color:red">{{ $errors->first('loginpassword') }}</div>
	                @endif
		        	<input type="password" placeholder="itsasecret" class="form-control" name="loginpassword" id="passwordlogin">
		        	<label class="passwrd">password</label>
	        	</div>


	        	<div class="remember">
	        		<label class="control control--checkbox">Remember Me
						<input type="checkbox" id="remember_me" name="remember" checked="checked" value="true">
						<div class="control__indicator"></div>
				  	</label>
				  	
	        	</div> 


	        	<div class="form-group text-center"> 
	        		<input type="hidden" value="{{ csrf_token() }}" name="_token">
		        	<input type="submit" value="sign in" id="signinButton">
	        	</div>
	        	<p>Don't have an account?</p>
	        	<a href="#" id="signup1" data-toggle="modal" data-target="#signup">sign up</a>
	        </form>
	    </div>
    </div>
  </div>
</div>