<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>About</title>
<link href="{{config('settings.FAVICON')}}" rel="shortcut icon" type="image/ico">
<link href="{{url('/')}}/public/css/bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/public/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('/')}}/public/fonts/font-awesome/css/font-awesome.min.css">

<script src="{{url('/')}}/public/js/jquery.min.js"></script>
<script src="{{url('/')}}/public/js/bootstrap.min.js"></script>


<link rel="stylesheet" type="text/css" href="https://t4t5.github.io/sweetalert/dist/sweetalert.css" />

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
</head>
<body>
<!-- Header Start -->
<header class="aboutheader">
	<div class="layer"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="logo">
					<a href="{{route('getIndex')}}"><img id="tier5_us" src="{{config('settings.SITE_LOGO')}}" class="img-responsive" alt="use linkwizard logo"></a>
				</div>
			</div>
			@include('registration.customheader')
		</div>
		<div class="row banner-middle text-center">
			<div class="banner-content">
				<h2>about us</h2>
				<p>Lorem Ipsum is simply dummy text of the printin.</p>
				<hr>
			</div>
		</div>
	</div>
</header>
<!-- Header End -->
<!-- Messenger chatbot extension -->
@include('chatbot_extension')
<!-- sign up modal start -->
@include('registration.customsignup')
<!-- sign up modal end -->
<!-- login modal start -->
@include('registration.customlogin')
<!-- login modal end -->

<section class="main-content about">
	<div class="first-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text eve when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="second-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Optimizing your internal link structure</h2>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
					<div class="clear"></div>
					<h2>Lorem Ipsum is simply dummys</h2>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="third-section twosectiongrid">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h2>
						<img src="{{url('/')}}/public/images/features.png" class="img-responsive">
						Features
					</h2>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer Lorem Ipsum is simply dummy text of the printins.</p>
				</div>
				<div class="col-md-6 col-sm-6">
					<img src="{{url('/')}}/public/images/img1.png" class="img-responsive">
				</div>
			</div>
		</div>
		<hr>
	</div>
	<div class="fourth-section twosectiongrid">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<img src="{{url('/')}}/public/images/img2.png" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-6">
					<h2>
						<img src="{{url('/')}}/public/images/analytics.png" class="img-responsive">
						advance analytics
					</h2>
					<p>Lorem Ipsum is simply dummy text of the printing typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer Lorem.</p>
				</div>
			</div>
		</div>
		<hr>
	</div>
	<div class="fifth-section twosectiongrid">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h2>
						<img src="{{url('/')}}/public/images/dataflexibility.png" class="img-responsive">
						data flexibility
					</h2>
					<p>Lorem Ipsum is simply dummy text of the printing typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer Lorem.</p>
				</div>
				<div class="col-md-6 col-sm-6">
					<img src="{{url('/')}}/public/images/img3.png" class="img-responsive">
				</div>
			</div>
		</div>
	</div>
</section>
<!-- <footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="footer-menu">
					<ul>
						<li><a href="#">About</a></li>
						<li><a href="#">Features</a></li>
						<li><a href="#">Blog</a></li>
						<li><a href="#">FAQ</a></li>
						<li><a href="#">Terms</a></li>
						<li><a href="#">Contact</a></li>
						<li><a href="#">Partners</a></li>
						<li><a href="#">Privacy</a></li>
					</ul>
				</div>
				<div class="social-icon">
					<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
				</div>
				<div class="copyright">
					<p>© All Rights Reserved to Tier5 LLC. </p>
				</div>
			</div>
		</div>
	</div>
</footer> -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
				<div class="col-md-8 col-sm-8">
					<div class="footer-menu">
						<ul>
							<li><a href="#">About</a></li>
							<li><a href="#">Features</a></li>
							<li><a href="#">Blog</a></li>
							<li><a href="#">FAQ</a></li>
							<li><a href="#">Terms</a></li>
							<li><a href="#">Contact</a></li>
							<li><a href="#">Partners</a></li>
							<li><a href="#">Privacy</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="social-icon">
					<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
				</div>

				</div>

				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
		<p>© All Rights Reserved to Tier5 LLC. </p>
	</div>


</footer>
</body>
<!-- ManyChat -->
<!-- <script src="//widget.manychat.com/216100302459827.js" async="async">
</script> -->

@include('loginjs')
</html>
