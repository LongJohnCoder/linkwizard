<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Branding</title>

<link href="{{url('/')}}/public/css/bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/public/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('/')}}/public/fonts/font-awesome/css/font-awesome.min.css">

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


  <div class="container centered" style="padding:140px">
    <div class="elelment">
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
      <div class="col-md-8 form">
        <div class="element-main">
      		<h1>Forgot Password</h1>
      		<p> Send a forgot pasword link in email! </p>
      		<form class="form" method="post" action="{{url('forgotPasswordEmail')}}">
            {{csrf_field()}}
      			<input style="width:80%" class="form-group" type="text" name="email" placeholder="Your e-mail address" value=""><br>
      			<input style="width:20%" class="form-group btn btn-success" type="submit" value="Send">
      		</form>
      	</div>
      </div>
    </div>
  </div>
  @include('registration.customfooter')

<!-- Main Content Start -->

</body>

<!-- ManyChat -->
<script src="//widget.manychat.com/216100302459827.js" async="async">
</script>

<!-- contains the js files for login and registration-->
    @include('loginjs')
</html>
