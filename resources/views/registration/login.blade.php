<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>

<style media="screen">
  .inputEmail{
    display: inline-block;
    width: 100%;
    margin-bottom: 10px;
  }
  @media screen and (max-width: 440px){
    div.headerLogo{
      width: 50%;
      margin-top: 10px;
    }
    div.headerLogo img{
      width: 100%;
    }
    .headerSignUp{
      line-height: 100%;
    }
    .headerSignUp a span{
      font-size: 16px !important;  
    }
  }

</style>

<link href="{{config('settings.FAVICON')}}" rel="shortcut icon" type="image/ico">
<link href="{{url('/')}}/public/css/bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/public/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('/')}}/public/fonts/font-awesome/css/font-awesome.min.css">
<link href="{{ URL::to('/').'/public/css/footer.css'}}" rel="stylesheet" />
<script src="{{url('/')}}/public/js/jquery.min.js"></script>
<script src="{{url('/')}}/public/js/bootstrap.min.js"></script>


<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/sweetalert/1.0.0/sweetalert.min.css" />

<script src="{{ URL::to('/').'/public/resources/js/modernizr.custom.js' }}"></script>
<link href="{{ URL::to('/').'/public/resources/css/bootstrap.min.css'}}" rel="stylesheet" />
<link href="{{ URL::to('/').'/public/resources/css/jquery.fancybox.css'}}" rel="stylesheet" />
<link href="{{ URL::to('/').'/public/resources/css/animate.css'}}" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
<link href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css' />
<link href="{{ URL::to('/').'/public/resources/css/styles.css'}}" rel="stylesheet" />
<link href="{{ URL::to('/').'/public/resources/css/queries.css'}}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css" />
</head>
<body>
<!-- Header Start -->
    <header>
        <section>
            <div class="container">
                <div class="row nav-wrapper">
                    <div class="col-md-6 col-sm-6 col-xs-6 text-left headerLogo">
                        <a href="{{ URL::to('/')}}"><img src="{{config('settings.SITE_LOGO')}}" alt="Boxify Logo"></a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-right headerSignUp"><br>
                        <a href="https://www.uselinkwizard.com"><span style="font-size:20px; color: #ffffff">Signup</span></a>
                    </div>
                </div>
            </div>
        </section>
    </header>
<!-- Header end -->
<!-- Main Content -->
<div class="container centered box">
    <div class="elelment">
        <div class="col-md-8 col-md-offset-2">
          <div>
            <div class="panel panel-default" style="margin-top: 40px;">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form method="post" action="{{ route('postLogin') }}">
                        {{csrf_field()}}
                        <!-- E-Mail Address -->
                        <div class="form-group inputEmail">
                            <label class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="loginemail" value="" autofocus>
                            </div>
                            @if($errors->any())
                                <div id="useremailValidation" style="color:red">{{ $errors->first('loginemail') }}</div>
                            @endif
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="loginpassword">
                            </div>
                            @if($errors->any())
                                <div id="passwordloginValidation" style="color:red">{{ $errors->first('loginpassword') }}</div>
                            @endif
                        </div>
                        <!-- Remember Me -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- Login Button -->
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa m-r-xs fa-sign-in"></i>Login
                                </button>

                                <a class="btn btn-link" href="{{route('forgotPassword')}}">Forgot Your Password?</a>
                            </div>
                        </div>
                        @if(\Session::has('error'))
                            <div class="form-group">
                                <div class="alert alert-danger col-md-10 col-md-offset-1">
                                    <p><center>{{\Session::get('error')}}</center></p>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
{{-- <div id="signin" class="tab-pane fade active in">
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
</div> --}}
