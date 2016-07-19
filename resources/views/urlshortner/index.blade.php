<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html lang="en" class="no-js">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Tier5|URL shortner</title>
		<meta name="description" content="A free HTML5/CSS3 template made exclusively for Codrops by Peter Finlan" />
		<meta name="keywords" content="html5 template, css3, one page, animations, agency, portfolio, web design" />
		<meta name="author" content="Peter Finlan" />
		<!-- Bootstrap -->
		<script src="{{ URL::to('/').'/public/resources/js/modernizr.custom.js' }}"></script>
		<link href="{{ URL::to('/').'/public/resources/css/bootstrap.min.css'}}" rel="stylesheet">
		<link href="{{ URL::to('/').'/public/resources/css/jquery.fancybox.css'}}" rel="stylesheet">
		
		<link href="{{ URL::to('/').'/public/resources/css/animate.css'}}" rel="stylesheet">
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
		<link href="{{ URL::to('/').'/public/resources/css/styles.css'}}" rel="stylesheet">
		<link href="{{ URL::to('/').'/public/resources/css/queries.css'}}" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css">



		<link rel="stylesheet" type="text/css" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css">
		<!-- Facebook and Twitter integration -->
		<meta property="og:title" content=""/>
		<meta property="og:image" content=""/>
		<meta property="og:url" content=""/>
		<meta property="og:site_name" content=""/>
		<meta property="og:description" content=""/>
		<meta name="twitter:title" content="" />
		<meta name="twitter:image" content="" />
		<meta name="twitter:url" content="" />
		<meta name="twitter:card" content="" />
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
	
	<!-- 	 -->
		<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		<!-- open/close -->
		<header>
			<section class="hero">
				<div class="texture-overlay"></div>
				<div class="container">
					<div class="row nav-wrapper">
						<div class="col-md-6 col-sm-6 col-xs-6 text-left">
							<a href="#"><img src="{{ URL::to('/').'/public/resources/img/company_logo.png' }}" alt="Boxify Logo"></a>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 text-right navicon">
							<p>Expand</p><a id="trigger-overlay" class="nav_slide_button nav-toggle" href="#"><span></span></a>
						</div>
					</div>
					<div class="row hero-content">
						<div class="col-md-12">
							<h1 class="animated fadeInDown">Paste Your URL Here:</h1>
							 
								
								
								<div class="row">
									<div class="col-sm-8">
										<!-- <a href="http://tympanus.net/codrops/?p=22554" class="use-btn animated fadeInUp">Use it for free</a> -->
										<input id="givenUrl" class="myInput" type="text" name="">
									</div>
									<div class="col-sm-4">
										<a id="swalbtn" style="cursor:pointer" class="learn-btn animated fadeInUp">Shorten Url</a>
										
									</div>
								</div>
								  								
						</div>
					</div>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<div class="row">
					<div class="col-md-4">
						
							

					</div>
					<div class="col-md-4">
						<p>© Tier5 2016 - Designed &amp; Developed by <a href="http://www.tier5.us/">Tier5</a></p>
					</div>
					<div class="col-md-4"></div>

				</div>
				
			</section>
		</header>
		
		
		<div class="overlay overlay-boxify">
			<nav>
			<p><a>For More Products From Us, Like:</a></p>
				<ul>
					<li><a><i class="fa fa-code"></i>Websites</a></li>
					<li><a><i class="fa fa-mobile"></i>Mobile Application</a></li>
				</ul>
				<ul>
					<li><a><i class="fa fa-cloud"></i>API</a></li>
					<li><a href="https://tier5.us/"><i class="fa fa-desktop"></i>Visit Our Website</a></li>
					
				</ul>
			</nav>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="{{ URL::to('/').'/public/resources/js/min/toucheffects-min.js'}}"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>

			<script type="text/javascript">
				$(document).ready(function(){

					var options = {
					    message:"Please wait a while"
					};

					

					$('#swalbtn').click(function(){
							
							  var url = $('#givenUrl').val();
							  var validUrl = ValidURL(url);
							  if(url)
							  {
							  	if(validUrl)
							  	{
							  		HoldOn.open(options);
								  	$.ajax({
								        type: "POST",
								        url: "{{route('postShortUrl')}}",
								        data: {url: url, _token: "{{Session::token()}}"},
								        success: function(response) {
								            
								            if(response.status=="success")
								            {
								            	console.log(response);

								            	var shortenUrl = response.id;


								            	var UrlWithLink = "<a href="+shortenUrl+">"+shortenUrl+"</a>";

								            	swal({
												  title: "Shorten Url:",
												  text: UrlWithLink,
												  type: "success",
												  html: true
												});	
												HoldOn.close();
								            }
								            else
								            {
								            	swal({
												  title: "",
												  text: "Response Error",
												  type: "warning",
												  html: true
												});	
												HoldOn.close();
								            }
								        },
								        error: function(response) {
								            console.log(response);
								            HoldOn.close();
								        }
									});
							  	}
							  	else
							  	{
							  		var errorMsg="Enter A Valid URL";
								  	swal({
										  title: "",
										  text: errorMsg,
										  type: "error",
										  html: true
										});	
							  	}
							  	
							  }
							  else
							  {
							  	var errorMsg="Please Enter An URL";
							  	swal({
									  title: "",
									  text: errorMsg,
									  type: "warning",
									  html: true
									});		
							  }
							  
					});


					function ValidURL(str) {
					  var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|gr|htm|html|cc|in|uk|us|pk)");
				        var url = str;
				        if (!regexp.test(url)) {
				            return false;
				        } else {
				            return true;
				        }
					}
					
				});
			
				
			
			</script>

		
		<script src="{{ URL::to('/').'/public/resources/js/jquery.fancybox.pack.js'}}"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="{{ URL::to('/').'/public/resources/js/retina.js'}}"></script>
		<script src="{{ URL::to('/').'/public/resources/js/waypoints.min.js'}}"></script>
		<script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
		<script src="{{ URL::to('/').'/public/resources/js/min/scripts-min.js'}}"></script>

		<script src="http://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>
		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
		<script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','UA-XXXXX-X');ga('send','pageview');
		</script>



	</body>
</html>
