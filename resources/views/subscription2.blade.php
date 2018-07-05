<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Subscription</title>

<link href="{{url('/')}}/public/css/bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/public/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('/')}}/public/fonts/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="{{url('/')}}/public/resources/css/creditCardTypeDetector.css">

<script src="{{url('/')}}/public/js/jquery.min.js"></script>
<script src="{{url('/')}}/public/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>

</head>
<body>
<!-- Header Start -->
<header>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="logo">
					<img src="{{config('settings.SITE_LOGO')}}" class="img-responsive">
				</div>
			</div>
			@include('registration.customheader')

		</div>
	</div>
</header>
<!-- Header End -->
<!-- Messenger chatbot extension -->
@include('chatbot_extension')
<!-- Main Content Start -->
@if(isset($session_plan) && $session_plan != null)
	<div>
		<h4 style="color:green"> select your plan and complete your subscription here  </h4>
	</div>
@endif

@if(\Session::has('subscription_success'))
	<div>
		<h4 style="color:">{{\Session::put('subscription_success')}}</h4>
	</div>
@endif



@if(\Session::has('subscription_success'))
	  <div id="er" class="alert alert-success" align="center"><strong>Success!</strong>\Session::get('subscription_success')<a href="javascript:void(0)" class="close" data-dismiss="success" aria-label="close" id="subs_succ">&times;</a></div>
@elseif(\Session::has('subscription_error'))
	  <div id="er" class="alert alert-error" align="center"><strong>Oops!</strong> Failed to create subscription try again <a href="javascript:void(0)" class="close" data-dismiss="success" aria-label="close" id="subs_fail">&times;</a></div>
@endif




<section class="main-content pricing">
	<div class="first-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Our service plans</h1>
					<p>Lorem Ipsum is simply dummy text of the printin.</p>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div id="freeTier" class="planbox">
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
						<a href="#">Subscribed</a>
					</div>
				</div>
				<div class="col-md-4">
					<div id="basicTier" class="planbox">
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

						@if ($subscription_status == 'tr5Basic')
                <a href="#">Subscribed</a>
            @else
            	<a href="#" id="basicButton">Subscribe now</a>
            @endif
					</div>
				</div>
				<div class="col-md-4">
					<div id="advancedTier" class="planbox">
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
						@if ($subscription_status == 'tr5Advanced')
                <a href="#">Subscribed</a>
            @else
            	<a href="#" id="advancedButton">Subscribe now</a>
            @endif
					</div>
				</div>
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

<script type="text/javascript " src="https://js.stripe.com/v2/ "></script>
<script src="{{url('/')}}/public/resources/js/jquery.creditCardTypeDetector.js "></script>
<script src="{{url('/')}}/public/js/parsley.js "></script>

<!-- ManyChat -->
<!-- <script src="//widget.manychat.com/216100302459827.js" async="async">
</script> -->


  <script>
		var public_key = "{{env('STRIPE_KEY')}}";
    Stripe.setPublishableKey(public_key);

    $(function() {
				console.log('public key :',public_key);
        $('#payment-form').submit(function(event) {
            var $form = $(this);
            var $btn = $('#submitBtn').button('loading');
            $form.parsley().subscribe('parsley:form:validate', function(formInstance) {
                formInstance.submitEvent.preventDefault();
                console.log('Submit disabled!');
                return false;
            });
            $form.find('#submitBtn').prop('disabled', true);
            Stripe.card.createToken($form, stripeResponseHandler);
            return false;
        });
    });

    function stripeResponseHandler(status, response) {
        var $form = $('#payment-form');
        if (response.error) {
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.payment-errors').addClass('alert alert-danger');
            $form.find('#submitBtn').prop('disabled', false);
            $('#submitBtn').button('reset');
        } else {
            var token = response.id;
            $form.append($('<input type="hidden " name="stripeToken " />').val(token));
            $form.get(0).submit();
            $('#stripeModal').modal('hide');
        }
    };

    </script>


<script type="text/javascript">
	$(document).ready(function() {



	var to_plan = '';
	var isset_plan = '{{ isset($session_plan) }}' ? true : false;



      var handler = StripeCheckout.configure({
      key: public_key,
      //image: '{{url("/")}}'+'/uploads/defaultuser.png',
      locale: 'auto',
      token: function(token) {
        console.log(token);
        var plan = to_plan;
        //alert('here');
        $('#loader').show();
        $.ajax({
          url: "{{route('postSubscription')}}",
          data: {stripeToken_:token.id , plan:plan , _token: '{!! csrf_token() !!}'},
          type :"post",
          success: function(url)
          {
						console.log('url is :',url);
         		$(location).attr('href',url);
          }
        });
      }
    });



		function handler_open(amount , plan)
		{
		  	to_plan = plan;
				console.log("name : {{url('/')}}" , "email: '{{$user->email}}'" , "amount : "+amount);
				handler.open({
		  	name: "{{url('/')}}",
		  	email: '{{$user->email}}',
		  	description: 'Invoice',
		  	amount: amount,
		  	currency: 'usd',
			});
		}



    // Close Checkout on page navigation:
    // $(window).on('popstate', function(){
    //   handler.close();
    // });

		// $(window).on('backward', function(){
    //   alert('alert');
    // });

    if(isset_plan)
		{
			var check_notnull = '{{ $session_plan != null }}' ? true : false;
			if(check_notnull)
			{
				var flag = "{{ $session_plan }}" , amount , plan;
				flag == 1 ? (amount = 1000 , plan = 'tr5Basic') : (amount = 2000 , plan = 'tr5Advanced');
				handler_open(amount , plan);
			}
		}



	    $(".menu-icon").click(function(){
	    	$(this).toggleClass("close");
	    	$('.mobile-menu ul').slideToggle(500);
	    });

	    //credit card type detector
	    $('#checkout_card_number').creditCardTypeDetector({
            'credit_card_logos': '.card_logos'
        });
        // from previous

	    var user_plan = '{{$subscription_status}}';

	    if(user_plan == 'tr5Advanced')
	    {
	    	$('#advancedTier').addClass("advanced");
	    }
	    else if(user_plan == 'tr5Basic')
	    {
	    	$('#basicTier').addClass("advanced");
	    }
	    else
	    {
	    	$('#freeTier').addClass("advanced");
	    }

	    $('#basicButton').on('click', function() {
	    	handler_open(1000 , 'tr5Basic');
            // $('#stripeModal').modal('show');
            // $('#money').text('$10');
            // $('#plan').val('tr5Basic');
        });
        $('#advancedButton').on('click', function() {
        	handler_open(2000 , 'tr5Advanced');
            // $('#stripeModal').modal('show');
            // $('#money').text('$20');
            // $('#plan').val('tr5Advanced');
        });


	    window.ParsleyConfig = {
	        errorsWrapper: '<div></div>',
	        errorTemplate: '<div class="alert alert-danger parsley " role="alert "></div>',
	        errorClass: 'has-error',
	        successClass: 'has-success'
	    };

	});
</script>

<script>
    (function(b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
            function() {
                (b[l].q = b[l].q || []).push(arguments)
            });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = '{{url('/')}}/public/js/google_analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X');
    ga('send', 'pageview');

</script>
</html>
