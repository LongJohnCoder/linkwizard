<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Branding</title>

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

<header class="brandingheader">
    <div class="layer"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-6">
                <div class="logo">
                    <img id="tier5_us" src="{{url('/')}}/public/images/logo.png" class="img-responsive">
                </div>
            </div>
            @include('registration.customheader')
        </div>
        
        <div class="row banner-middle text-center">
            <div class="banner-content">
                <h2>Make your links manageable.</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and industry.</p>
                <form>
                    <div class="col-md-9">
                        <div class="row">
                            <input type="text" id="givenUrl" placeholder="Paste a link to shorten it">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <input id="swalbtn" type="submit" value="Shorten URL">
                        </div>
                    </div>
                </form>
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
                    <h1>Shorten, compare and optimize all your links</h1>
                    <p>Ready to start! Simple attractive and easy to use</p>
                    <div class="clear"></div>
                    <div class="col-md-4">
                        <div class="threeblock">
                            <img src="{{url('/')}}/public/images/link.png" class="img-responsive">
                            <h2>link</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and industry.Lorem Ipsum has beenthe industry's.</p>
                            <a href="#">Learn more <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="threeblock">
                            <img src="{{url('/')}}/public/images/track.png" class="img-responsive">
                            <h2>Track</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and industry.Lorem Ipsum has beenthe industry's.</p>
                            <a href="#">Learn more <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="threeblock">
                            <img src="{{url('/')}}/public/images/optimize.png" class="img-responsive">
                            <h2>optimize</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and industry.Lorem Ipsum has beenthe industry's.</p>
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
                    <h2>About Link Management</h2>
                    <hr>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled</p>
                    <a href="#">Learn More</a>
                </div>
                <div class="col-md-6">
                    <img src="{{url('/')}}/public/images/desktop.png" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
    <div class="videosection">
        <div class="container-fluid">
            <div class="row">
                <img src="{{url('/')}}/public/images/vdo-img.jpg" class="img-responsive">
                <div class="video-container">
                    <iframe class="video" width="560" height="313" src="https://www.youtube.com/embed/vaf13ZhmFb8?enablejsapi=1&amp;version=3&amp;playerapiid=ytplayer&amp;rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" marginwidth="0" marginheight="0" hspace="0" vspace="0" scrolling="no" allowfullscreen allowscriptaccess="always"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="benefit text-center">
        <div class="container">
            <div class="row">
                <h1>LInk Management Benefits</h1>
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
</body>
<!-- contains the js files for login and registration-->
    @include('loginjs') 
</html>