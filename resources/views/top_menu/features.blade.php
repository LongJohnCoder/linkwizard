<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Feature</title>

<link href="{{url('/')}}/public/css/bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/public/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('/')}}/public/fonts/font-awesome/css/font-awesome.min.css">

<script src="{{url('/')}}/public/js/jquery.min.js"></script>
<script src="{{url('/')}}/public/js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css" />

<script src="{{ URL::to('/').'/public/resources/js/modernizr.custom.js' }}"></script>
<link href="{{ URL::to('/').'/public/resources/css/bootstrap.min.css'}}" rel="stylesheet" />
<link href="{{ URL::to('/').'/public/resources/css/jquery.fancybox.css'}}" rel="stylesheet" />
<link href="{{ URL::to('/').'/public/resources/css/animate.css'}}" rel="stylesheet" />
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css' />
<link href="{{ URL::to('/').'/public/resources/css/styles.css'}}" rel="stylesheet" />
<link href="{{ URL::to('/').'/public/resources/css/queries.css'}}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css" />
</head>
<body>
<!-- Header Start -->
<header class="aboutheader">
	<div class="layer"></div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="logo">
					<img src="{{url('/')}}/public/images/logo.png" class="img-responsive">
				</div>
			</div>
			@include('registration.customheader')
		</div>
		<div class="row banner-middle text-center">
			<div class="banner-content">
				<h2>shorten, compare and optimize all your links</h2>
				<p>Lorem Ipsum is simply dummy text of the printin.</p>
				<hr>
			</div>
		</div>
	</div>
</header>
<!-- Header End -->
<!-- Main Content Start -->

@include('registration.customsignup')
<!-- sign up modal end -->
<!-- login modal start -->
@include('registration.customlogin')
<!-- login modal end -->
<section class="main-content feature">
	<div class="first-section">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<h2>Shorten link</h2>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
					<div class="clear"></div>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>
				</div>
				<div class="col-md-5">
					<img src="{{url('/')}}/public/images/feature1.png" class="img-responsive">
				</div>
			</div>
		</div>
	</div>
	<div class="second-section">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<img src="{{url('/')}}/public/images/feature2.png" class="img-responsive">
				</div>
				<div class="col-md-7">
					<h2>Advanced analytics</h2>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
					<div class="clear"></div>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>
				</div>
			</div>
		</div>
	</div>	
	<div class="first-section">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<h2>Optimization</h2>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
					<div class="clear"></div>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has.</p>
				</div>
				<div class="col-md-7">
					<img src="{{url('/')}}/public/images/feature3.png" class="img-responsive">
				</div>
			</div>
		</div>
	</div>
	<div class="end-section text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3>100 % free to sign up</h3>
					<a href="#">start today</a>
				</div>
			</div>
		</div>
	</div>
</section>
<footer>
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
</footer>
</body>
<script type="text/javascript">
	$(document).ready(function() {
	    $(".menu-icon").click(function(){
	    	$(this).toggleClass("close");
	    	$('.mobile-menu ul').slideToggle(500);
	    });
	});
</script>
@include('loginjs')
</html>