<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forget Password</title>

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
                    <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                        <a href="{{ URL::to('/')}}"><img src="{{config('settings.SITE_LOGO')}}" alt="Boxify Logo"></a>

                    </div>

                </div>

            </div>

        </section>
  </header>
<!-- Header end -->

<!-- Main Content start -->
    <div class="overlay overlay-boxify">
        <nav>
            <ul>
                @if (Auth::user())
                <li>
                    <a href="{{ route('getDashboard') }}">
                        <i class="fa fa-tachometer"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('getLogout') }}">
                        <i class="fa fa-sign-out"></i>Logout
                    </a>
                </li>
                @else
                <li>
                    <a href="#signin" data-toggle="modal" id="loginButton" data-target=".bs-modal-md">
                        <i class="fa fa-user"></i>Login
                    </a>
                </li>
                <li>
                    <a href="#signup" data-toggle="modal" id="registerButton" data-target=".bs-modal-md">
                        <i class="fa fa-sign-in"></i>Register
                    </a>
                </li>
                @endif
                <li>
                    <a target="_blank" href="https://tier5.us/">
                        <i class="fa fa-desktop"></i>Visit Our Website
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="container centered box" >
      <div class="elelment">

        <div class="col-md-8 col-md-offset-2 form">
          <div>
            @if(\Session::has('errs'))
                <div class="alert alert-danger">
                    <p>{{\Session::get('errs')}}</p>
                </div>
            @endif

            @if(\Session::has('success'))
              <div class="alert alert-success">
                    <p>{{\Session::get('success')}}</p>
              </div>
            @endif
          </div>
          <div class="element-main">
        		<h1>Forgot Password</h1>
        		<p> Send a forgot pasword link in email! </p>
        		<form class="form" method="post" action="{{url('forgotPasswordEmail')}}">
              {{csrf_field()}}
        			<input  class="form-control" type="text" name="email" placeholder="Your e-mail address" value=""><br>
        			<input style="width:20%" class="form-group btn btn-success" type="submit" value="Send">
        		</form>
        	</div>
        </div>
      </div>
    </div>
<!-- Main Content end -->

<!-- Footer start -->
  @include('registration.customfooter')
<!-- Footer end -->
</body>

<!-- ManyChat -->
<script src="//widget.manychat.com/216100302459827.js" async="async">
</script>

<!-- contains the js files for login and registration-->
    @include('loginjs')
</html>
