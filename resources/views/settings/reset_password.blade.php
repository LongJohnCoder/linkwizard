<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reset Password</title>

<link href="{{ URL('/')}}/public/images/favicon.ico" rel="shortcut icon" type="image/ico">
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
                        <a href="{{ URL::to('/')}}"><img src="{{ URL::to('/').'/public/images/logo.png' }}" alt="Boxify Logo"></a>
                    </div>
                    
                </div>
              
            </div>
           
        </section>
  </header>
<!-- Header end -->

<!-- Main Content start -->
  <div class="container centered box" >
    <div class="elelment">
      @if(\Session::has('errs'))
          <div class="alert alert-danger">
              <p>{{\Session::get('errs')}}</p>
          </div>
      @endif

      @if(\Session::has('forget_success'))
          <div class="alert alert-success">
              <p>{{\Session::get('forget_success')}}</p>
          </div>
      @endif
      <div class="col-md-8 col-md-offset-2">
       
      </div><br>
      <div class="col-md-8 col-md-offset-2 form">
        <div class="element-main">
         <h2>Reset Password Form</h2>
      		<form class="form" method="post" action="{{url('set-password')}}">
            {{csrf_field()}}
           
              <!-- Sign Up Form -->
              <!-- Text input-->
              <div class="control-group form-group">
                  <label for="Name" class="control-label">Email:</label>
                  <div class="controls">
                      <input class="form-control" type="email" name="email" placeholder="Your e-mail address" value=" {{ $email }}" readonly>
                  </div>
              </div>
              
              <!-- Password input-->
              <div class="control-group form-group">
                  <label for="password" class="control-label">Password:</label>
                  <div class="controls">
                      <input class="form-control" type="password" name="password" placeholder="Set Password" value="" id="password">
                  </div>
              </div>
              <!-- Text input-->
              <div class="control-group form-group">
                  <label for="password_confirmation" class="control-label">Confirm Password:</label>
                  <div class="controls">
                      <input class="form-control" type="password" name="password_confirmation" placeholder="Set Confirm Password" value="" id="password_confirmation">
                  </div>
              </div>
              <!-- Button -->
              <div class="control-group form-group">
                  <div class="controls">
                      <input type="hidden" name="token">
                      <input class="form-control btn btn-success" type="submit" value="submit">
                  </div>
              </div>
            
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
