<style type="text/css">
	.clear{
	    clear: both;
	    display: inline-block;
	    width: 100%
	}

	.modal .modal-header {
	    padding: 10px;
	    background-color: #ffffff;
	    border-bottom: 0;
	}

	.modal .modal-content{
	    border-radius: 0;
	}
	.modal-body{
		background-color: #ffffff;
	}

	.modal h1{
	    font-family:'OpenSans-ExtraBold';
	    color: #000;
	    text-transform: capitalize;
	    font-size: 27px;
	    margin: 0;
	}

	.modal form{
	    padding: 10px 0;
	}

	.modal-body input{
	    width: 100%;
	    border-bottom: 1px solid #eee;
	    border-left: 0;
	    border-right: 0;
	    border-top: 0;
	    font-size: 18px;
	    color: #000;
	    height: 50px;
	    transition: 0.5s;
	}

	.modal-body input:focus{
	    outline: none;
	    border-bottom: 1px solid #000;
	}

	.modal-body input[type='password']{
	    border-bottom: 1px solid #000;
	}

	.modal-body label.passwrd{
	    color: #000;
	}

	.modal-body label{
	    font-family:'OpenSans-Bold';
	    color: #B0B0B0;
	    text-transform: uppercase;
	    font-size: 12px;
	}

	.btn{
	    background: #4C90FF;
	    color: #fff;
	    display: inline-block;
	    font-family: 'OpenSans-Semibold';
	    text-transform: uppercase;
	    font-size: 16px;
	    margin: 20px 0;
	}

	.modal-body input[type='submit']{
	    display: inline-block;
	    color: #fff;
	    font-family: 'OpenSans-Semibold';
	    text-transform: uppercase;
	    font-size: 16px;
	    width: 55%;
	    margin: 20px 0;
	}
	.modal-body p{
	    color: #ABABAB;
	    text-align: center;
	}

	.modal-body a{
	    color: #000;
	    text-align: center;
	    font-family: 'OpenSans-Bold';
	    text-transform: capitalize;
	    display: block;
	    font-size: 16px;
	}

	.modal-body a.forgot{
	    font-family: 'OpenSans-Regular';
	    color: #4C90FF;
	    display: inline-block;
	    float: right;
	    font-size: 14px;
	}

	.remember{
	    margin: 20px 0 0;
	}

	/* checkbox style */
	.modal-body .control {
	    position: relative;
	    display: inline-block;
	    padding-left: 30px;
	    cursor: pointer;
	    font-family: 'OpenSans-Regular';
	    color: #000;
	    text-transform: capitalize;
	    font-weight: normal;
	    font-size: 14px;
	}
</style>
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="login_btn" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
	        <h1>Sign In</h1>
	        <form method="post" action="{{ route('postLogin') }}"  id="signin_form">
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


	        	<div class="remember" style="display:none">
	        		<label class="control control--checkbox">Remember Me
						<input type="checkbox" id="remember_me" name="remember" checked="checked" value="true">
						<div class="control__indicator"></div>
				  	</label>

	        	</div>


	        	<div class="form-group text-center">
	        		<input type="hidden" name="__plan" id="_plan" value="">
	        		<input type="hidden" value="{{ csrf_token() }}" name="_token">
		        	<input type="submit" value="sign in" id="signinButton" class="btn btn-primary form-control">
              		<a href="{{route('forgotPassword')}}">Forgot Password</a>
	        	</div>
	        	<!--<p>Don't have an account?</p>
	        	<a href="#" id="signup1" data-toggle="modal" data-target="#signup">sign up</a>-->
	        </form>
	    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#signin_form').submit(function(e){
				if(!$('#useremail').val() || !$('#passwordlogin').val()) {

					e.preventDefault();
					 swal({
		                title: "Please fill all fields Properly",
		                text: "Error",
		                type: "warning",
		                html: true
        			});
				} 
			});
	});
</script>
