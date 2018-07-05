<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>About</title>

<link href="{{url('/')}}/public/css/bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/public/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('/')}}/public/fonts/font-awesome/css/font-awesome.min.css">
<script src="{{url('/')}}/public/js/jquery.min.js"></script>
<script src="{{url('/')}}/public/js/bootstrap.min.js"></script>
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
<!-- Main Content Start -->
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
				<div class="col-md-6">
					<h2>
						<img src="images/features.png" class="img-responsive">
						Features
					</h2>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer Lorem Ipsum is simply dummy text of the printins.</p>
				</div>
				<div class="col-md-6">
					<img src="images/img1.png" class="img-responsive">
				</div>
			</div>
		</div>
		<hr>
	</div>
	<div class="fourth-section twosectiongrid">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<img src="images/img2.png" class="img-responsive">
				</div>
				<div class="col-md-6">
					<h2>
						<img src="images/analytics.png" class="img-responsive">
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
				<div class="col-md-6">
					<h2>
						<img src="images/dataflexibility.png" class="img-responsive">
						data flexibility
					</h2>
					<p>Lorem Ipsum is simply dummy text of the printing typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer Lorem.</p>
				</div>
				<div class="col-md-6">
					<img src="images/img3.png" class="img-responsive">
				</div>
			</div>
		</div>
	</div>
</section>
@include('registration.customfooter')
</body>

<!-- ManyChat -->
<!-- <script src="//widget.manychat.com/216100302459827.js" async="async">
</script> -->

<script type="text/javascript">
	$(document).ready(function() {
	    $(".menu-icon").click(function(){
	    	$(this).toggleClass("close");
	    	$('.mobile-menu ul').slideToggle(500);
	    });
	});
</script>
</html>
