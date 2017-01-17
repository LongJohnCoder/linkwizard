<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      	 <div class="modal-header">
        	<button type="button" id="signup_btn" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
	     <div class="modal-body">
	        <h1>sign up</h1>
	        <form method="post" id="signup_form" action="{{ route('postRegister') }}" onsubmit="return validateHumanity();">
	        	<div class="form-group"> 
	        		@if($errors->any())
                		<div id="NameValidation" style="color:red">{{ $errors->first('name') }}</div>
                	@endif
		        	<input type="text" placeholder="John Doe" class="form-control" name="name" id="Name" value="{{ old('name') }}">
		        	<label>username</label>
	        	</div>

	        	<div class="form-group"> 
	        		@if($errors->any())
                		<div id="EmailValidation" style="color:red">{{ $errors->first('email') }}</div>
                	@endif
		        	<input type="email" placeholder="johndoe@company.io" class="form-control" name="email" id="Email" value="{{ old('email') }}">
		        	<label>email</label>
	        	</div>

	        	<div class="form-group"> 
	        		@if($errors->any())
	                	<div id="passwordValidation" style="color:red">{{ $errors->first('password') }}</div>
	                @endif
		        	<input type="password" placeholder="itsasecret" class="form-control" name="password" id="password">
		        	<label class="passwrd">password</label>
	        	</div>


	        	<div class="form-group"> 
	        		@if($errors->any())
	                	<div id="password_confirmationValidation" style="color:red">{{ $errors->first('password_confirmation') }}</div>
	                @endif
		        	<input type="password" placeholder="itsasecret" name="password_confirmation" class="form-control" id="password_confirmation">
		        	<label class="passwrd">confirm password</label>
	        	</div>

	        	<div class="form-group" style="display:none"> 
	        		<label for="humancheck" class="control-label">Humanity Check:</label>
	        		<img src="{{url('/')}}/public/images/captcha.jpg" class="img-responsive">
	        	</div>

	        	<div class="form-group text-center"> 
	        		<input type="hidden" name="_plan" id="_plan" value="">
	        		<input type="hidden" value="{{ csrf_token() }}" name="_token">
		        	<input type="submit" id="confirmsignup" value="sign up">
	        	</div>

	        	<p>Already have an account?</p>
	        	<a href="#" data-toggle="modal" id="login1" data-target="#login">sign in</a>
	        </form>
	    </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#signup_form').submit(function(e){
				
				console.log(check_name , check_email , check_password , check_cpassword);
				if(check_name && check_email && check_password && check_cpassword)
				{
					
				}
				else{
					e.preventDefault();
					alert('please fill all details properly');
				}
				
			});
	});
</script>