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
				<ul>
					<li><a href="#signup" data-toggle="modal" id="loginButton" data-target=".bs-modal-sm"><i class="fa fa-user"></i>Login</a></li>
					<li><a id="registerButton"><i class="fa fa-sign-in"></i>Register</a></li>
				</ul>
				<ul>
					<li><a href="https://tier5.us/"><i class="fa fa-desktop"></i>Visit Our Website</a></li>
					
				</ul>
			</nav>
		</div>


		<!-- Modal -->
<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <br>
        <div class="bs-example bs-example-tabs">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#signin" id="signInTab" style="color: #284666;" data-toggle="tab">Sign In</a></li>
              <li class=""><a href="#signup" id="signUpTab" style="color: #284666;" data-toggle="tab">Register</a></li>
              <li class=""><a href="#why" style="color: #284666;" data-toggle="tab">Why?</a></li>
            </ul>
        </div>
      <div class="modal-body">
        <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in" id="why">
        <p>We need this information so that you can receive access to the site and its content. Rest assured your information will not be sold, traded, or given to anyone.</p>
        <p></p><br> Please contact <a mailto:href="JoeSixPack@Sixpacksrus.com"></a>JoeSixPack@Sixpacksrus.com</a> for any other inquiries.</p>
        </div>
        <div class="tab-pane fade active in" id="signin">
            <form class="form-horizontal" action="{{route('LoginAttempt')}}" method="post">
            <fieldset>
            <!-- Sign In Form -->
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="userid">Email:</label>
              <div class="controls">
                <input required="" id="userid" name="email" type="email" class="form-control" placeholder="JoeSixpack" class="input-medium" required="">
              </div>
            </div>

            <!-- Password input-->
            <div class="control-group">
              <label class="control-label" for="passwordinput">Password:</label>
              <div class="controls">
                <input required="" id="passwordinput" name="password" class="form-control" type="password" placeholder="********" class="input-medium">
              </div>
            </div>

            <!-- Multiple Checkboxes (inline) -->
            <div class="control-group">
              <label class="control-label" for="rememberme"></label>
              <div class="controls">
                <label class="checkbox inline" for="rememberme-0">
                  <input type="checkbox" name="rememberme" id="rememberme-0" value="Remember me">
                  Remember me
                </label>
              </div>
            </div>

            <!-- Button -->
            <div class="control-group">
              <label class="control-label" for="signin"></label>
              <div class="controls">
              	<input type="hidden" name="_token" value="{{Session::token()}}">
                <button id="signin" type="submit" style="background:#284666; color: #fff;" name="signin" class="btn btn-success">Sign In</button>
              </div>
            </div>
            </fieldset>
            </form>
        </div>
        <div class="tab-pane fade" id="signup">
            <form class="form-horizontal" action="{{route('postRegister')}}" method="post">
            <fieldset>
            <!-- Sign Up Form -->
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="Email">Email:</label>
              <div class="controls">
                <input id="Email" name="Email" class="form-control" type="email" placeholder="JoeSixpack@sixpacksrus.com" class="input-large" required="">
              </div>
            </div>
            
            <!-- Password input-->
            <div class="control-group">
              <label class="control-label" for="password">Password:</label>
              <div class="controls">
                <input id="password" name="password" class="form-control" type="password" placeholder="********" class="input-large" required="">
              </div>
            </div>
            
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="reenterpassword">Re-Enter Password:</label>
              <div class="controls">
                <input id="reenterpassword" class="form-control" name="reenterpassword" type="password" placeholder="********" class="input-large" required="">
              </div>
            </div>
            
            <!-- Multiple Radios (inline) -->
            <br>
            <div class="control-group">
              <label class="control-label" for="humancheck">Humanity Check:</label>
              <div class="controls">
                <label class="radio inline" for="humancheck-0">
                  <input type="radio" name="humancheck" id="humancheck" value="robot" checked="checked" required="">I'm a Robot</label>
                <label class="radio inline" for="humancheck-1">
                  <input type="radio" name="humancheck" id="humancheck" value="human" required="">I'm Human</label>
              </div>
            </div>
            
            <!-- Button -->
            <div class="control-group">
              <label class="control-label" for="confirmsignup"></label>
              <div class="controls">
                <input type="hidden" name="_token" value="{{Session::token()}}">
                <button id="confirmsignup" style="background:#284666; color: #fff;" type="submit" class="btn btn-success">Sign Up</button>
              </div>
            </div>
            </fieldset>
            </form>
      </div>
    </div>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" style="background:#284666; color: #fff;" class="btn btn-default" data-dismiss="modal">Close</button>
        </center>
      </div>
    </div>
  </div>
</div>



		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="{{ URL::to('/').'/public/resources/js/min/toucheffects-min.js'}}"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
			    
			   @if(Session::has('fail'))
				   <script type="text/javascript">
				   	$(document).ready(function(){
				   		swal({
							  title: "Error",
							  text: "{{Session::get('fail')}}",
							  type: "error",
							  html: true
							});
					});	
				   </script>
                 
               @else
               @endif
               @if(Session::has('success'))
	               <script type="text/javascript">
	               	$(document).ready(function(){
	               		swal({
							  title: "Success",
							  text: "{{Session::get('success')}}",
							  type: "success",
							  html: true
							});	
	               	});
	               </script>
                 <!-- <div class="alert alert-success"><strong>Success!</strong> {{Session::get('success')}}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                 </div> -->
               @else
               @endif


			<script type="text/javascript">
				$(document).ready(function(){



					$('#loginButton').click(function(){
						$('.nav-toggle').click();
						$('#signInTab').click();
					});
					$('#registerButton').click(function(){
						$('.nav-toggle').click();
						$('#myModal').modal('show');
						$('#signUpTab').click();
					});


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
