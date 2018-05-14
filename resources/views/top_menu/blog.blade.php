<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Blog</title>
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
<body>
<!-- Header Start -->
<header>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="logo">
					<a href="{{route('getIndex')}}"><img id="tier5_us" src="{{config('settings.SITE_LOGO')}}" class="img-responsive" alt="use linkwizard logo"></a>
				</div>
			</div>
			@include('registration.customheader')
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
<section class="main-content blog">
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-sm-9">
				<div class="blog-section">
					<div class="row">
						<div class="col-md-12">
							<div class="single-blog">
								<a href="#">
									<img src="{{url('/')}}/public/images/blog1.jpg" class="img-responsive">
									<span class="date">08 Mar</span>
								</a>
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<span class="cat">
											<a href="#">08 Mar 2016 | in analytics, features</a>
										</span>
									</div>
									<div class="col-md-6 col-sm-6 text-right">
										<span class="author">
											<a href="#">Author | J K paul</a>
										</span>
										<span class="comments">
											<a href="#">comments | 215</a>
										</span>
									</div>
								</div>
								<div class="blog-txt">
									<p>Lorem ipsum doler ameet is editable. Simply click anywhere in the paragraph or heading text and start typing.</p>
									<a href="#" class="read">Read</a>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="single-blog">
								<a href="#">
									<img src="{{url('/')}}/public/images/blog2.jpg" class="img-responsive">
									<span class="date">11 feb</span>
								</a>
								<div class="row">
									<div class="col-md-12">
										<span class="cat">
											<a href="#">11 feb 2016 | in analytics</a>
										</span>
									</div>
								</div>
								<div class="blog-txt">
									<p>Simply click anywhere in the or heading text and start.</p>
									<a href="#" class="read">Read</a>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="single-blog">
								<a href="#">
									<img src="{{url('/')}}/public/images/blog3.jpg" class="img-responsive">
									<span class="date">20 Mar</span>
								</a>
								<div class="row">
									<div class="col-md-12">
										<span class="cat">
											<a href="#">11 feb 2016 | in analytics</a>
										</span>
									</div>
								</div>
								<div class="blog-txt">
									<p>Simply click anywhere in the or heading text and start.</p>
									<a href="#" class="read">Read</a>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="single-blog">
								<a href="#">
									<img src="{{url('/')}}/public/images/blog4.jpg" class="img-responsive">
									<span class="date">08 Mar</span>
								</a>
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<span class="cat">
											<a href="#">08 Mar 2016 | in analytics, features</a>
										</span>
									</div>
									<div class="col-md-6 col-sm-6 text-right">
										<span class="author">
											<a href="#">Author | J K paul</a>
										</span>
										<span class="comments">
											<a href="#">comments | 215</a>
										</span>
									</div>
								</div>
								<div class="blog-txt">
									<p>Lorem ipsum doler ameet is editable. Simply click anywhere in the paragraph or heading text and start typing.</p>
									<a href="#" class="read">Read</a>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="single-blog">
								<a href="#">
									<img src="{{url('/')}}/public/images/blog5.jpg" class="img-responsive">
									<span class="date">08 Mar</span>
								</a>
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<span class="cat">
											<a href="#">08 Mar 2016 | in analytics, features</a>
										</span>
									</div>
									<div class="col-md-6 col-sm-6 text-right">
										<span class="author">
											<a href="#">Author | J K paul</a>
										</span>
										<span class="comments">
											<a href="#">comments | 215</a>
										</span>
									</div>
								</div>
								<div class="blog-txt">
									<p>Lorem ipsum doler ameet is editable. Simply click anywhere in the paragraph or heading text and start typing.</p>
									<a href="#" class="read">Read</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3">
				<div class="sidebar">
					<div class="category">
						<h2>Category</h2>
						<ul>
							<li><a href="#">best practices</a></li>
							<li><a href="#">pro</a></li>
							<li><a href="#">beyond social</a></li>
							<li><a href="#">storytelling</a></li>
							<li><a href="#">features</a></li>
							<li><a href="#">proTip</a></li>
							<li><a href="#">from elizabeth</a></li>
							<li><a href="#">marketing</a></li>
							<li><a href="#">saturday morning storytelling</a></li>
							<li><a href="#">lists</a></li>
						</ul>
					</div>
					<div class="topics">
						<h2>browse by topics</h2>
						<ul>
							<li><a href="#">best practices</a></li>
							<li><a href="#">pro</a></li>
							<li><a href="#">beyond social</a></li>
							<li><a href="#">storytelling</a></li>
							<li><a href="#">features</a></li>
							<li><a href="#">proTip</a></li>
							<li><a href="#">from elizabeth</a></li>
							<li><a href="#">marketing</a></li>
							<li><a href="#">saturday morning storytelling</a></li>
							<li><a href="#">lists</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('registration.customfooter')
</body>
<!-- ManyChat -->
<script src="//widget.manychat.com/216100302459827.js" async="async">
</script>
@include('loginjs')
</html>
