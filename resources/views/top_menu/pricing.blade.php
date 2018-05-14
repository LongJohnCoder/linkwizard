@if(\Auth::check())
	@include('subscription2')
@else
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pricing</title>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha256-fvFKHgcKai7J/0TM9ekjyypGDFhho9uKmuHiFVfScCA=" crossorigin="anonymous"></script>
</head>
<body>
<!-- Header Start -->
<header>
	<div class="container-fluid">
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
<section class="main-content pricing">
	<div class="first-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Our service plans</h1>
					<p>For pricing details contact us at <a href="tel:+15022890035">(502)-289-0035</a></p>
					<p>OR</p>
				</div>
			</div>
			<div class="row">
      <div class="col-md-12">
        <div class="well well-sm">
        <div id="successMsg" style="color: green" class="text-center"></div>
        <div id="errorMsg" style="color: red" class="text-center"></div>
          <form class="form-horizontal" action="" id="price-request-form" method="post">
          <fieldset>
            <h2 class="text-center">Contact us</h2>
            <!-- Name input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Name</label>
              <div class="col-md-9">
                <input name="contact_name" type="text" placeholder="Your name" id="conatct-Name" class="form-control" required="required">
              </div>
            </div>
    
            <!-- Email input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="email">E-mail</label>
              <div class="col-md-9">
                <input name="contact_email" type="email" placeholder="Your email" id="conatct-Email" class="form-control" required="required">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="email">Phone</label>
              <div class="col-md-9">
                <input name="conatct_phone" type="phone" placeholder="Your phone" id="conatct-Phone" class="form-control" required="required">
                <span class="invalidContactNumber" style="color: red"></span>
              </div>
            </div>
            
    
            <!-- Message body -->
            <div class="form-group">
              <label class="col-md-3 control-label" for="message">Message</label>
              <div class="col-md-9">
                <textarea class="form-control" id="conatct-Message" name="conatct_message" placeholder="Please enter your message here..." rows="5"></textarea>
              </div>
            </div>
    
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-lg" id="requestForPricing">Submit</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
      </div>

					<!--<div class="planbox" id="noPlan">
						<h2>free</h2>
						<div class="value">
							$<span> 0 / </span>month per user
						</div>
						<div class="shortenlink">
							Upto 10 shorten links
						</div>
						<ul class="offers">
							<li><span>10</span> shorten links</li>
							<li><span>basic</span> analytics</li>
							<li><span>no</span> custom links</li>
							<li><span>no</span> support</li>
						</ul>
							<a href="#" data-toggle="modal" data-target="#signup" id="new_noplan">Subscribe now</a>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="planbox" id="basicTier">
						<h2>advanced</h2>
						<div class="value">
							$<span> 10 / </span>month per user
						</div>
						<div class="shortenlink">
							Upto 100 shorten links
						</div>
						<ul class="offers">
							<li><span>100</span> shorten links</li>
							<li><span>advanced</span> analytics</li>
							<li><span>custom</span> links</li>
							<li><span>business</span> hour support</li>
						</ul>

							<a href="#" data-toggle="modal" data-target="#signup" id="new_tr5Basic">Subscribe now</a>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="planbox" id="advancedTier">
						<h2>pro</h2>
						<div class="value">
							$<span> 20 / </span>month per user
						</div>
						<div class="shortenlink">
							Unlimited shorten links
						</div>
						<ul class="offers">
							<li><span>unlimited</span> shorten links</li>
							<li><span>advanced</span> analytics</li>
							<li><span>custom</span> links</li>
							<li><span>24 X 7</span> hour support</li>
						</ul>
							<a href="#" data-toggle="modal" data-target="#signup" id="new_tr5Advanced">Subscribe now</a>
					</div>
				</div>-->
			</div>
		</div>
	</div>
	<div class="customplan text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Need a custom plan?</h1>
					<p>Book a voice call or <a href="mailto:support@loremodels.com">support@loremodels.com</a></p>
				</div>
			</div>
		</div>
	</div>
	<div class="faq">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>frequently asked questions</h1>
					<div class="quesbox">
						<p class="ques">Can I bring my existing domain and links with me?</p>
						<p class="ans">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen</p>
					</div>
					<div class="clear"></div>
					<div class="quesbox">
						<p class="ques">Can I bring my existing domain and links with me?</p>
						<p class="ans">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen</p>
					</div>
					<div class="clear"></div>
					<div class="quesbox">
						<p class="ques">Can I bring my existing domain and links with me?</p>
						<p class="ans">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen</p>
					</div>
					<div class="clear"></div>
					<div class="quesbox">
						<p class="ques">Can I bring my existing domain and links with me?</p>
						<p class="ans">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen</p>
					</div>
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

<!-- ManyChat -->
<script src="//widget.manychat.com/216100302459827.js" async="async">
</script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript">

 $(document).ready(function() {
	 $("#conatct-Phone").on('blur', function() {
		  validateUSNumber(this);
		});
		function validateUSNumber(selector) {
			var a = $(selector).val();
    		var filter = /^(1\s?)?((\([0-9]{3}\))|[0-9]{3})[\s\-]?[\0-9]{3}[\s\-]?[0-9]{4}$/;
    		if (filter.test(a)) {
        		$('.invalidContactNumber').hide();
				$('#requestForPricing').prop("disabled",false);
    		}
    		else {
			$('.invalidContactNumber').text("Invalid US Phone Number");
        	$('.invalidContactNumber').show();
			$('#requestForPricing').prop("disabled",true);
    		}
		 }
 });

	Stripe.setPublishableKey('pk_test_NeErELVu7Qbv59BWm0c7HQT1');

	$('#noPlan').mouseover(function(){
		$('#noPlan').addClass('advanced');
	});
	$('#noPlan').mouseout(function(){
		$('#noPlan').removeClass('advanced');
	});
	$('#basicTier').mouseover(function(){
		$('#basicTier').addClass('advanced');
	});
	$('#basicTier').mouseout(function(){
		$('#basicTier').removeClass('advanced');
	});
	$('#advancedTier').mouseover(function(){
		$('#advancedTier').addClass('advanced');
	});
	$('#advancedTier').mouseout(function(){
		$('#advancedTier').removeClass('advanced');
	});

	$('#new_noplan').click(function(){
		$('#_plan').val(0);
		$('#__plan').val(0);
	});
	$('#new_tr5Basic').click(function(){
		$('#_plan').val(1);
		$('#__plan').val(1);
	});
	$('#new_tr5Advanced').click(function(){
		$('#_plan').val(2);
		$('#__plan').val(2);
	});
                $('#price-request-form').submit(function (event) {
                    event.preventDefault();
                    var data = {
                        "userName": $('#conatct-Name').val(),
                        "userEmail": $('#conatct-Email').val(),
                        "userPhone": $('#conatct-Phone').val(),
                        "userMsg": $('#conatct-Message').val()
                    };
                    $.ajax({
                        type: "post",
                        url: "{{ route('priceRequest') }}",
                        data: {
                            userName: $('#conatct-Name').val(),
                            userEmail: $('#conatct-Email').val(),
                            userPhone: $('#conatct-Phone').val(),
                            userMsg: $('#conatct-Message').val(),
                        },
                        success: function (response) {
                            if(response == 'MessageSent'){
                                $('#successMsg').append("Mail Send Successfully");
                                console.log("Mail Send Successfully");
                            } else {
                                console.log("Sorry failed");
                                $('#errorMsg').append("Sorry failed");
                            }
                        }
                    });
                    return false;
                });
</script>





@include('loginjs')
</html>
@endif
