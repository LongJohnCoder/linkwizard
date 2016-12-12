<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="{{ URL::to('/').'/public/resources/img/favicon.ico' }}">
<title>Tier5 | URL Shortener</title>
<meta name="description" content="A free URL shortner brought to you by Tier5 LLC." />
<meta name="keywords" content="Tier5 URL Shortner, Tr5.io, Tier5" />
<meta name="author" content="Tier5 LLC" />

<title>Branding</title>

<link href="{{url('/')}}/public/css/bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/public/css/style.css" rel="stylesheet">
<link rel="{{url('/')}}/public/stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>


<!-- from older version -->
<link href="{{ URL::to('/').'/public/resources/css/bootstrap.min.css'}}" rel="stylesheet" />
    <link href="{{ URL::to('/').'/public/resources/css/jquery.fancybox.css'}}" rel="stylesheet" />
    <link href="{{ URL::to('/').'/public/resources/css/animate.css'}}" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css' />
    <link href="{{ URL::to('/').'/public/resources/css/styles.css'}}" rel="stylesheet" />
    <link href="{{ URL::to('/').'/public/resources/css/queries.css'}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css" />
    <link rel="stylesheet" type="text/css" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css" />

<!-- from older version -->

<script src="{{url('/')}}/public/js/jquery.min.js"></script>
<script src="{{url('/')}}/public/js/bootstrap.min.js"></script>
<script src="http://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>

<script type="text/javascript" src="{{url('/')}}/public/js/jquery.flexisel.js"></script>
</head>
<body>
<!-- Header Start -->
<header class="brandingheader">
    <div class="layer"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-6">
                <div class="logo">
                    <img src="{{url('/')}}/public/images/logo.png" class="img-responsive">
                </div>
            </div>
            <div class="col-md-8">
                <div class="top-menu">
                    <div class="mobile-menu">
                        <div class="hamburg-menu">
                          <a href="#" class="menu-icon" style="display: block;">
                            <div class="span bar top" style="background-color: #fff;"></div>
                            <div class="span bar middle" style="background-color: #fff;"></div>
                            <div class="span bar bottom" style="background-color: #fff;"></div>
                          </a>
                        </div>
                        <ul>
                            <li><a href="#">about</a></li>
                            <li><a href="#">features</a></li>
                            <li><a href="#">pricing</a></li>
                            <li><a href="#">blog</a></li>
                            <li class="login"><a href="#">login</a></li>
                            <li class="signup"><a href="#">signup</a></li>
                        </ul>
                    </div>
                    <div class="desktop-menu">
                        <ul>
                            <li><a href="#">about</a></li>
                            <li><a href="#">features</a></li>
                            <li><a href="#">pricing</a></li>
                            <li><a href="#">blog</a></li>
                            <li class="login"><a href="#">login</a></li>
                            <li class="signup"><a href="#">signup</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row banner-middle text-center">
            <div class="banner-content">
                <h2>Make your links manageable.</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and industry.</p>
                <form>
                    <div class="col-md-9">
                        <div class="row">
                            <input id="givenUrl" type="text" placeholder="Paste a link to shorten it">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            
                            <button id="swalbtn" class="btn">Shorten URL</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".menu-icon").click(function(){
            $(this).toggleClass("close");
            $('.mobile-menu ul').slideToggle(500);
        });
        var address_ = "{{url('/')}}";
        var options = {
            theme: "custom",
            content: '<img style="width:80px;" src="'+address_+'/public / resources / img / company_logo.png" class="center-block">',
            message: "Please wait a while",
            backgroundColor: "#212230"
        };

          $('#swalbtn').click(function(e) 
          {

            var url = $('#givenUrl').val();
            var validUrl = ValidURL(url);
            
            e.preventDefault();
            @if(Auth::user())
            var userId = {
                {
                    Auth::user() ->id;
                }
            };
            @else
            var userId = 0;
            @endif
            if (url) {
                
                if (validUrl) {
                    HoldOn.open(options);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('postShortUrlTier5') }}",
                        data: {
                            url: url,
                            user_id: userId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status == "success") {
                                var shortenUrl = response.url;
                                var displayHtml = "<a href=" + shortenUrl + " target='_blank' id='newshortlink'>" + shortenUrl + "</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink'><i class='fa fa-clipboard'></i> Copy</button>";
                                swal({
                                    title: "Shorten Url:",
                                    text: displayHtml,
                                    type: "success",
                                    html: true
                                });
                                new Clipboard('#clipboardswal');
                                HoldOn.close();
                            } else {
                                swal({
                                    title: null,
                                    text: "Please paste an actual URL",
                                    type: "warning",
                                    html: true
                                });
                                HoldOn.close();
                            }
                        },
                        error: function(response) {
                            console.log('Response error!');
                            HoldOn.close();
                        },
                        statusCode: {
                            500: function() {
                                console.log('500 internal server error!');
                                swal({
                                    title: null,
                                    text: "Access Forbidden, Please paste a valid URL!",
                                    type: "error",
                                    html: true
                                });
                                HoldOn.close();
                            }
                        }
                    }); //ajax ends here
                } else {
                    var errorMsg = "Enter A Valid URL";
                    swal({
                        title: null,
                        text: errorMsg,
                        type: "error",
                        html: true
                    });
                }
            } 
            else {
                var errorMsg = "Please Enter An URL";
                swal({
                    title: null,
                    text: errorMsg,
                    type: "warning",
                    html: true
                });   
            }
            
        });

        function ValidURL(str) 
        {
            var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|ac|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
            var url = str;
            if (!regexp.test(url)) {
                alert('retrning false');
                return false;
            } else {
                alert('retrning true');
                return true;
            }
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".videosection img").click(function(e){
            $(this).hide();
            $(this).parent().find(".video")[0].src += "&autoplay=1";
            e.preventDefault();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.carousel-control').click(function(){
            $(this).addClass("clicked");
            $('.carousel-control').not($(this)).removeClass("clicked");
        });
    });
</script>

<script type="text/javascript">
    $(window).load(function() {
        $("#flexiselDemo3").flexisel({
            visibleItems: 4,
            itemsToScroll: 1,         
            autoPlay: {
                enable: true,
                interval: 5000,
                pauseOnHover: true
            }        
        });
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
        e.src = '//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X');
    ga('send', 'pageview');

    </script>

</html>