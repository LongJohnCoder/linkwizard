<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home</title>
<link href="{{config('settings.FAVICON')}}" rel="shortcut icon" type="image/ico">
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
<!-- Messenger chatbot extension -->
        @include('chatbot_extension')
<!-- Header Start -->

<header class="brandingheader">
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
                <h2>Business Owners: Meet Smart Links</h2>
                <p style="margin: 80px">{{config('settings.AD.PLATFORM_NAME')}} {{--config('settings.AD.HEADING')--}} not only shortens your link into a "pretty" URL, but it also gives your business the tracking and protection you need to scale</p>
                <div class="formArea">
                <div class="formContainer">
                    <form id="shortenUrlForm" method="POST" action="{{route('postShortUrlNoLogin')}}" enctype="multipart/form-data" files=true>
                        <div class="col-md-9 resForm">
                            <div class="row">
                                <input type="text" name="url" id="givenUrl" placeholder="Paste a link to shorten it">
                            </div>
                        </div>
                        <div class="col-md-3 resForm">
                            <div class="row">
                                <div id="settingBtn"><i class="fa fa-gear"></i></div>
                                <button id="swalbtn1" type="button" class="shortenUrlBtn">Shorten URL</button>
                            </div>
                        </div>
                    <div class="clear"></div>
                    <div class="formDropdown" style="display:none;">
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Add facebook pixel
                                <input type="checkbox" id="checkboxAddFbPixelid" name="checkboxAddFbPixelid">
                                <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body facebook-pixel">
                                <p>Paste Your Facebook-pixel-id Here</p>
                                <input type="number" name="fbPixelid" class="form-control" id="fbPixel_id">
                            </div>
                        </div>

                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Add google pixel
                                <input type="checkbox" id="checkboxAddGlPixelid" name="checkboxAddGlPixelid">
                                <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body google-pixel">
                                <p>Paste Your Google-pixel-id Here</p>
                                <input type="text" name="glPixelid" class="form-control" id="glPixel_id">
                            </div>
                        </div>

                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Link Preview
                                <input type="checkbox" id="link_preview_selector" name="link_preview_selector">
                                <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body link-preview">
                                <ul>
                                    <li>
                                        <label class="custom-checkbox">Use Original
                                        <input type="checkbox" checked id="link_preview_original" name="link_preview_original">
                                        <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="custom-checkbox">Use Custom
                                        <input type="checkbox" id="link_preview_custom" name="link_preview_custom">
                                        <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                                <div class="use-custom">

                                    <div class="white-paneel">
                                        <div class="white-panel-header">Image</div>
                                                                        <div class="white-panel-body">
                                            <ul>
                                                <li>
                                                    <label class="custom-checkbox">Use Original
                                                    <input checked type="checkbox" id="org_img_chk" name="org_img_chk">
                                                    <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox">Use Custom
                                                    <input type="checkbox" id="cust_img_chk" name="cust_img_chk">
                                                    <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom1 img-inp">
                                                <input type="file" class="form-control" id="img_inp" name="img_inp">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="white-paneel">
                                        <div class="white-panel-header">Title</div>
                                        <div class="white-panel-body">
                                            <ul>
                                                <li>
                                                    <label class="custom-checkbox">Use Original
                                                    <input checked type="checkbox" id="org_title_chk" name="org_title_chk">
                                                    <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox">Use Custom
                                                    <input type="checkbox" id="cust_title_chk" name="cust_title_chk">
                                                    <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom1 title-inp">
                                                <input type="text" class="form-control" id="title_inp" name="title_inp">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="white-paneel">
                                        <div class="white-panel-header">Description</div>
                                        <div class="white-panel-body">
                                            <ul>
                                                <li>
                                                    <label class="custom-checkbox">Use Original
                                                    <input checked type="checkbox" id="org_dsc_chk" name="org_dsc_chk">
                                                    <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox">Use Custom
                                                    <input type="checkbox" id="cust_dsc_chk" name="cust_dsc_chk">
                                                    <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom2 dsc-inp">
                                                <textarea class="form-control" id="dsc_inp" name="dsc_inp"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                                                {{--
                                    <div class="white-paneel">
                                        <div class="white-panel-header">URL</div>
                                        <div class="white-panel-body">
                                            <ul>
                                                <li>
                                                    <label class="custom-checkbox">Use Original
                                                    <input checked type="checkbox" id="org_url_chk" name="org_url_chk">
                                                    <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox">Use Custom
                                                    <input type="checkbox" id="cust_url_chk" name="cust_url_chk">
                                                    <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom3 url-inp">
                                                <input type="text" class="form-control" name="url_inp" id="url_inp">
                                            </div>
                                        </div>
                                    </div>
                                                                --}}


                                </div>
                            </div>
                        </div>
                    </div>
                    </form>


                </div>
                </div>

            </div>
        </div>
    </div>
</header>
@include('registration.customsignup')
<!-- sign up modal end -->
<!-- login modal start -->
@include('registration.customlogin')
<!-- Header End -->
<!-- Main Content Start -->
<section class="main-content branding">
    <div class="first-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Get Unprecedented and Total Control Over Your Links</h1>
                    <p>Easily create links that track and route your visitors to EXACTLY where you want them to go.</p>
                    <div class="clear"></div>
                    <div class="col-md-4">
                        <div class="threeblock">
                            <img src="{{url('/')}}/public/images/link.png" class="img-responsive">
                            <h2>link</h2>
                            <p>Create short, "pretty" links in seconds for your websites, documents, photos and videos.</p>
                            <a href="#">Learn more <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="threeblock">
                            <img src="{{url('/')}}/public/images/track.png" class="img-responsive">
                            <h2>Track</h2>
                            <p>Get real-time data on who is clicking your links. Embed your Facebook and Google pixel.</p>
                            <a href="#">Learn more <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="threeblock">
                            <img src="{{url('/')}}/public/images/optimize.png" class="img-responsive">
                            <h2>Customize</h2>
                            <p>Create customization links, embed password protection, and utilize geo-routing features (Coming Soon).</p>
                            <a href="#">Learn more <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="linkmanage">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>About Link Wizard</h2>
                    <hr>
                    <p>Link Wizard is a very powerful link management software. It allows you to create custom short links, track link clicks and get in depth analytics. You can also add a Facebook Pixel or Google Pixel to any of your short links.</p>
                    <a href="#">Learn More</a>
                </div>
                <div class="col-md-6">
                    <img src="{{url('/')}}/public/images/desktop.png" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="container">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="videosection">
                <img src="{{url('/')}}/public/images/vdo-img.jpg" class="img-responsive">
                <div class="video-container">
                    <iframe class="video" width="560" height="313" src="https://www.youtube.com/embed/vaf13ZhmFb8?enablejsapi=1&amp;version=3&amp;playerapiid=ytplayer&amp;rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" marginwidth="0" marginheight="0" hspace="0" vspace="0" scrolling="no" allowfullscreen allowscriptaccess="always"></iframe>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="benefit text-center">
        <div class="container">
            <div class="row">
                <h1>Link Management Benefits</h1>
                <p>Ready to start! simple attractive and easy to use copy</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <ul>
                        <li>Lorem ipsum dolers dels</li>
                        <li>Lorem ipsum dolers delenes</li>
                        <li>Conversion Tracking</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul>
                        <li>Lorem ipsum dors</li>
                        <li>Track Tumblr Visitors</li>
                        <li>Link Cloaking</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul>
                        <li>Branded Links</li>
                        <li>Lorem ipsum oldels</li>
                        <li>Source Tracking</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="testimonial">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h2>our client say</h2>
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="item-box">
                        <div class="carousel-inner text-center">
                            <div class="item active">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="thumbnail adjust1">
                                            <img class="img-responsive" src="{{url('/')}}/public/images/testimonial.jpg">
                                            <div class="caption">
                                                <h3>Selina  Flense</h3>
                                                <span>San Fransisco</span>
                                                <p>Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Donec id elit non mi porta gravida at eget metus. Curabitur blandit tempus porttitor.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="thumbnail adjust1">
                                            <img class="img-responsive" src="{{url('/')}}/public/images/testimonial2.jpg">
                                            <div class="caption">
                                                <h3>Sara</h3>
                                                <span>San Fransisco</span>
                                                <p>Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Donec id elit non mi porta gravida at eget metus. Curabitur blandit tempus porttitor.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="brands text-center">
        <div class="container">
            <div class="row">
                <h2>trusted by the brands</h2>
                <p>Lorem ipsum dels version of Lorem Ipsum. Proin gravida nibh vel velit  aliquet. Aenean sollicitudin,lorem quis bibendum auctor, nisi elit.</p>
                <div class="logos">
                    <ul id="flexiselDemo3">
                        <li><img src="{{url('/')}}/public/images/logo1.png" class="img-responsive"/></li>
                        <li><img src="{{url('/')}}/public/images/logo2.png" class="img-responsive"/></li>
                        <li><img src="{{url('/')}}/public/images/logo3.png" class="img-responsive"/></li>
                        <li><img src="{{url('/')}}/public/images/logo4.png" class="img-responsive"/></li>

                        <!-- <li><img src="images/logo3.png" class="img-responsive"/></li>
                        <li><img src="images/logo1.png" class="img-responsive"/></li>
                        <li><img src="images/logo4.png" class="img-responsive"/></li>
                        <li><img src="images/logo2.png" class="img-responsive"/></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@include('registration.customfooter')
<div id="BlurBack"></div>

</body>

<!-- ManyChat -->
<!-- ManyChat Bar Widget Js  DO NOT REMOVE -->
<!--<script src="//widget.manychat.com/216100302459827.js" async="async"></script>-->
<script>
    $(document).ready(function(){
        var formPosTop = $(".formContainer").position().top;

        var clickCount = 0;

        $("#settingBtn").click(function(){
            var scroll = $(document).scrollTop();
            //var formOfset = formPosTop + scroll;
            //alert(scroll)
            var docH = $(document).height();
            var shorterUrlForm =  $("#shortenUrlForm").html();

            if(clickCount%2 == 0){
                $(".formContainer").appendTo("#BlurBack");
                $("#BlurBack").css("height",docH+"px");
                $("#BlurBack").fadeIn(500);
                $(".formContainer").css("top",formPosTop+200 + "px");
                $(".formContainer").addClass("show");
                setTimeout(function() {
                    $(".formDropdown").slideDown();
                }, 500);

            }
            else{
                $(".formDropdown").slideUp();
                 setTimeout(function() {
                    $(".formContainer").appendTo(".formArea");
                    $("#BlurBack").fadeOut(500);
                    $(".formContainer").css("top","0px");
                }, 500);
            }

            clickCount = clickCount+1;


        });



	var maintainSidebar = function(thisInstance) {

		//for url
		if(thisInstance.id === "org_url_chk") {
			if(thisInstance.checked) {
				$('.url-inp').hide();
				$('#url_inp').val('');
				$('#url_inp').hide();
				$("#cust_url_chk").attr("checked",false);
			} else {
			}
		}

		if(thisInstance.id === "cust_url_chk") {
			if(thisInstance.checked) {
				$('.url-inp').show();
				$('#url_inp').show();
				$("#org_url_chk").attr("checked",false);
			} else {
				$('.url-inp').hide();
				$('#url_inp').hide();
				$('#url_inp').val('');
			}
		}

		//for description
		if(thisInstance.id === "org_dsc_chk") {
			if(thisInstance.checked) {
				$('.dsc-inp').hide();
				$('#dsc_inp').val('');
				$('#dsc_inp').hide();
				$("#cust_dsc_chk").attr("checked",false);
			} else {
			}
		}

		if(thisInstance.id === "cust_dsc_chk") {
			if(thisInstance.checked) {
				$('.dsc-inp').show();
				$('#dsc_inp').show();
				$("#org_dsc_chk").attr("checked",false);
			} else {
				$('.dsc-inp').hide();
				$('#dsc_inp').hide();
				$('#dsc_inp').val('');
			}
		}

		//for title
		if(thisInstance.id === "org_title_chk") {
			if(thisInstance.checked) {
				$('.title-inp').hide();
				$('#title_inp').val('');
				$('#title_inp').hide();
				$("#cust_title_chk").attr("checked",false);
			} else {
			}
		}

		if(thisInstance.id === "cust_title_chk") {
			if(thisInstance.checked) {
				$('.title-inp').show();
				$('#title_inp').show();
				$("#org_title_chk").attr("checked",false);
			} else {
				$('.title-inp').hide();
				$('#title_inp').hide();
				$('#title_inp').val('');
			}
		}

		//for image
		if(thisInstance.id === "org_img_chk") {
			if(thisInstance.checked) {
				$('.img-inp').hide();
				$('#img_inp').val('');
				$('#img_inp').hide();
				$("#cust_img_chk").attr("checked",false);
			} else {
			}
		}

		if(thisInstance.id === "cust_img_chk") {
			if(thisInstance.checked) {
				$('.img-inp').show();
				$('#img_inp').show();
				$("#org_img_chk").attr("checked",false);
			} else {
				$('.img-inp').hide();
				$('#img_inp').hide();
				$('#img_inp').val('');
			}
		}

		//alert(1234);
		//facebook analytics checkbox for short urls
		if (thisInstance.id === "checkboxAddFbPixelid") {
			if(thisInstance.checked) {
				$('.facebook-pixel').show();
				$('#fbPixel_id').show();
			} else {

				$('.facebook-pixel').hide();
				$('#fbPixel_id').val('');
				$('#fbPixel_id').hide();
			}
		}

		//facebook analytics checkbox for custom urls
		// if (thisInstance.id === "checkboxAddFbPixelid1" && thisInstance["name"] === "chk_fb_custom") {
		// 	if(thisInstance.checked) {
		// 		$('#fbPixelid1').show();
		// 	} else {
		// 		$('#fbPixelid1').hide();
		// 		$('#fbPixelid1').val('');
		// 	}
		// }

		//google analytics checkbox for short urls
		// if (thisInstance.id === "checkboxAddGlPixelid" && thisInstance["name"] === "chk_gl_short") {
		// 	if(thisInstance.checked) {
		// 		$('#glPixelid').show();
		// 	} else {
		// 		$('#glPixelid').hide();
		// 		$('#glPixelid').val('');
		// 	}
		// }

		//google analytics checkbox for custom urls
		if (thisInstance.id === "checkboxAddGlPixelid") {
			if(thisInstance.checked) {
				$('.google-pixel').show();
				$('#glPixel_id').show();
			} else {
				$('.google-pixel').hide();
				$('#glPixel_id').hide();
				$('#glPixel_id').val('');
			}
		}

		//addtags for short urls

		if (thisInstance.id === "shortTagsEnable") {
			if(thisInstance.checked) {

				$('.add-tags').show();
				$('#shortTags_Area').show();
      } else {
        $('.add-tags').hide();
				$('#shortTags_Area').hide();
        $("#shortTags_Contents").val('');
				var select = $(".chosen-select-header");
        select.find('option').prop('selected', false);
        select.trigger("chosen:updated");

			}
		}


		if (thisInstance.id === "descriptionEnable") {
			if(thisInstance.checked) {
				$('#descriptionArea').show();
				$('#descriptionContents').show();
			} else {
				$('#descriptionContents').hide();
				$('#descriptionContents').val('');
				$('#descriptionArea').hide();
			}
		}

		if(thisInstance.id === "link_preview_selector" && thisInstance["name"] === "link_preview_selector") {
			if(thisInstance.checked) {
				$('.link-preview').show();
			} else {
				$('.link-preview').hide();
			}
		}

		if(thisInstance.id === 'link_preview_original') {
			if(thisInstance.checked) {
				$('#link_preview_custom').attr("checked", false);
				$('.use-custom').hide();
			} else {
				//$('#link_preview_').hide();
				//$('#link_preview_original').hide();
			}
		}

		if(thisInstance.id === 'link_preview_custom') {
			if(thisInstance.checked) {
				$('.use-custom').show();
				$('#link_preview_original').attr("checked",false);
			} else {
				//$('#link_preview_').hide();
				$('.use-custom').hide();
			}
		}

	}

	$(document).ready(function() {

		$("#dashboard-search-btn").on('click',function() {
			console.log('came here : submitting form');
			var data = $("#dashboard-search-form").serialize();
			$("#dashboard-search-form").submit();
		});


		$("#dashboard-search").on('click',function() {
			var tags = $("#dashboard-tags-to-search").tagsinput('items');
			var text = $("#dashboard-text-to-search").val();
			console.log('tags :',tags,' text: ',text);
		});




		$("input[type='checkbox']").on("change", function() {
      maintainSidebar(this);
    });



		$(this).on('click', '.menu-icon', function(){
	    	$(this).addClass("close");
	    	$('#userdetails').slideToggle(500);
	    	$('#myNav1').hide();
	    	$('#myNav2').hide();
	    });

	    $("#basic").click(function(){
	    	$('.menu-icon').addClass("close");
	    	$('#myNav1').slideToggle(500);
	    	$('#myNav2').hide();
	    	$('#userdetails').hide();
				maintainSidebar(this);
	    });

	    $("#advanced").click(function(){
	    	$('.menu-icon').addClass("close");
	    	$('#myNav2').slideToggle(500);
	    	$('#myNav1').hide();
	    	$('#userdetails').hide();
				maintainSidebar(this);
	    });

	    $(this).on('click', '.close', function(){
        	$('.userdetails').hide();
        	$(this).removeClass("close");
        });

		      //$('[data-toggle="tooltip"]').tooltip();
        $('#hamburger').on('click', function () {
            $('.sidebar.right').addClass('open', true);
            $('.sidebar.right').removeClass('close', true);
        });
        $('#cross').on('click', function () {
            $('.sidebar.right').toggleClass('close', true);
            $('.sidebar.right').removeClass('open', true);
        });
        $('#tr5link').on('click', function () {
            $('.tr5link').addClass('open', true);
            $('.tr5link').removeClass('close', true);
        });

        $('#customLink').on('click', function () {
            $('.sharebar').addClass('open', true);
            $('.sharebar').removeClass('close', true);
        });
        $('#cross2').on('click', function () {
            $('.sharebar').addClass('close', true);
            $('.sharebar').removeClass('open', true);
        });
        $('#noTr5Link').on('click', function () {
            swal({
                type: 'warning',
                title: 'Notification',
                text: 'You have maximum shorten links. Please upgrade account to get hassle free services.'
            });
        });
        $('#noCustomLink').on('click', function () {
            swal({
                type: 'warning',
                title: 'Notification',
                text: 'You have maximum shorten links. Please upgrade account to get hassle free services.'
            });
        });


	});

    });
</script>


<!-- contains the js files for login and registration-->
    @include('loginjs')

    <script type="text/javascript">
    @if(\Session::has('url_shorten_no_session_type'))

      @if(\Session::get('url_shorten_no_session_type') == 'success')

          var options = {
              theme: "custom",
              content: '<img style="width:80px;" src="{{config('settings.SITE_LOGO')}}" class="center-block">',
              message: "Please wait a while",
              backgroundColor: "#212230"
          };

          @if(\Session::has('url_shorten_no_session_SURL'))
          //setTimeout(function() {
            HoldOn.open(options);
            var surl = "{{\Session::get('url_shorten_no_session_SURL')}}";
            var txtToShw = "<a href=" + surl + " target='_blank' id='newshortlink'>" + surl + "</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink'><i class='fa fa-clipboard'></i> Copy</button>";
            swal({
                title: "Shorten Url:",
                text: txtToShw,
                type: "{{\Session::get('url_shorten_no_session_type')}}",
                html: true
            });
            new Clipboard('#clipboardswal');
            HoldOn.close();
          @endif
          //}, 300);
      @else

        //error
        var this_er_msg = 'Some error occoured!';
        @if(\Session::has('url_shorten_no_session_msg'))
          this_er_msg = \Session::get('url_shorten_no_session_msg');
        @endif

        swal({
            title: null,
            text: this_er_msg,
            type: "warning",
            html: true
        });
        HoldOn.close();
      @endif

    @endif
    </script>
</html>
