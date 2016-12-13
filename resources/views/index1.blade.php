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
<header class="brandingheader">
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

<script src="http://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
<script src="{{ URL::to('/').'/public/resources/js/min/toucheffects-min.js'}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>

<script type="text/javascript">


    $(document).ready(function() {
        $(".menu-icon").click(function(){
            $(this).toggleClass("close");
            $('.mobile-menu ul').slideToggle(500);
        });
        // previous functions here


         $('#useremail').on('blur', function() {
            emailInput = $(this).val();
            emailRegex = new RegExp('^([a-zA-Z0-9-_\.])+@([a-z0-9]+[\.]+[a-z]{2,}([\.]*[a-z]){0,2}){1}$');
            if (emailInput.length === 0) {
                $(this).focus();
                $('#useremailValidation').remove('#useremailValidation');
                $(this).parent().append("<span id='useremailValidation' style='color: red'>Email field should not be blank.</span>");
                return false;
            } else if (!emailRegex.test(emailInput)) {
                $(this).focus();
                $('#useremailValidation').remove('#useremailValidation');
                $(this).parent().append("<span id='useremailValidation' style='color: red'>Please enter a valid email address.</span>");
                return false;
            } else {
                $('#useremailValidation').remove('#useremailValidation');
                return true;
            }
        });

    $('#useremail').on('keypress', function() {
            $('#useremailValidation').remove('#useremailValidation');
        });

        $('#passwordlogin').on('blur', function() {
            passwordInput = $(this).val();
            if (passwordInput.length === 0) {
                $(this).focus();
                $('#passwordloginValidation').remove('#passwordloginValidation');
                $(this).parent().append("<span id='passwordloginValidation' style='color: red'>Password field should not be blank.</span>");
                return false;
            } else {
                $('#passwordloginValidation').remove('#passwordloginValidation');
                return true;
            }
        });

        $('#passwordlogin').on('keypress', function() {
            $('#passwordloginValidation').remove('#passwordloginValidation');
        });

        $('#Name').on('blur', function(e) {
            nameRegex = new RegExp('^([a-zA-Z\. ]){2,}$');
            nameInput = $(this).val();
            if (nameInput.length === 0) {
                $(this).focus();
                $('#NameValidation').remove('#NameValidation');
                $(this).parent().append("<span id='NameValidation' style='color: red'>Name field should not be blank.</span>");
                return false;
            } else if (!nameRegex.test(nameInput)) {
                $(this).focus();
                $('#NameValidation').remove('#NameValidation');
                $(this).parent().append("<span id='NameValidation' style='color: red'>Please enter a valid name. Name should contain letters and space.</span>");
                return false;
            } else {
                $('#NameValidation').remove('#NameValidation');
                return true;
            }
        });

        $('#Name').on('keypress', function () {
            $('#NameValidation').remove('#NameValidation');
        });

        $('#Email').on('blur', function () {
            emailInput = $(this).val();
            emailRegex = new RegExp('^([a-zA-Z0-9-_\.])+@([a-z0-9]+[\.]+[a-z]{2,}([\.]*[a-z]){0,2}){1}$');
            if (emailInput.length === 0) {
                $(this).focus();
                $('#EmailValidation').remove('#EmailValidation');
                $(this).parent().append("<span id='EmailValidation' style='color: red'>Email field should not be blank.</span>");
                return false;
            } else if (!emailRegex.test(emailInput)) {
                $(this).focus();
                $('#EmailValidation').remove('#EmailValidation');
                $(this).parent().append("<span id='EmailValidation' style='color: red'>Please enter a valid email address.</span>");
                return false;
            } else {
                $.ajax({
                    type: 'post',
                    url: '{{ route('postEmailCheck') }}',
                    data: {
                        email: emailInput,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if(response.exist) {
                            $('#Email').focus();
                            $('#EmailValidation').remove('#EmailValidation');
                            $('#Email').parent().append("<span id='EmailValidation' style='color: red'>This email is already registered.</span>");
                            return false;
                        } else {
                            $('#EmailValidation').remove('#EmailValidation');
                            return true;
                        }
                    },
                    error: function (response) {
                        console.log('Response error!');
                    },
                    statusCode: function (response) {
                        console.log('Internal server error!');
                    }
                });
                $('#EmailValidation').remove('#EmailValidation');
                return true;
            }
        });

        $('#Email').on('keypress', function () {
            $('#EmailValidation').remove('#EmailValidation');
        });

        $('#password').on('keyup', function() {
            passwordRegex =  new RegExp('(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#%^&*_+\-=?\.]).{8,}');
            passwordInput = $(this).val();
            if (passwordInput.length === 0) {
                $(this).focus();
                $('#passwordValidation').remove('#passwordValidation');
                $(this).parent().append("<span id='passwordValidation' style='color: red'>Password field should not be blank.</span>");
                return false;
            } else if (!passwordRegex.test(passwordInput)) {
                $(this).focus();
                $('#passwordValidation').remove('#passwordValidation');
                $(this).parent().append("<span id='passwordValidation' style='color: red'>Password should be atleast eight characters long and contain one lowercase, one uppercase, one numeric and one special character.</span>");
                return false;
            } else {
                $('#passwordValidation').remove('#passwordValidation');
                return true;
            }
        });

        /*$('#password').on('keypress', function () {
            $('#passwordValidation').remove('#passwordValidation');
        });*/

        $('#password_confirmation').on('keyup', function() {
            password_confirmationRegex =  new RegExp('(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#%^&*_+\-=?\.]).{8,}');
            password_confirmationInput = $(this).val();
            passwordInput = $('#password').val();
            if (password_confirmationInput.length === 0) {
                $(this).focus();
                $('#password_confirmationValidation').remove('#password_confirmationValidation');
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Confirm password field should not be blank.</span>");
                return false;
            } else if (!password_confirmationRegex.test(password_confirmationInput)) {
                $(this).focus();
                $('#password_confirmationValidation').remove('#password_confirmationValidation');
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Password should be atleast eight characters long and contain one lowercase, one uppercase, one numeric and one special character.</span>");
                return false;
            } else if (passwordInput !== password_confirmationInput) {
                $(this).focus();
                $('#password_confirmationValidation').remove('#password_confirmationValidation');
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Password and confirm password should match.</span>");
                return false;
            } else {
                $('#password_confirmationValidation').remove('#password_confirmationValidation');
                return true;
            }
        });

        var onReturnCallback = function() {
            alert("grecaptcha is ready!");
        };

        function validateHumanity() {
            submit.preventDefault();
            var captcha_response = grecaptcha.getResponse();
            alert(captcha_response);
            if(captcha_response.length == 0) {
                $('#reCAPTCHA_div').parent().append("<span id='humancheckValidation' style='color: red'>Prove that you are not a robot!</span>");
                return false;
            } else {
                $('#humancheckValidation').remove('#humancheckValidation');
                return true;
            }
        }



        var options = {
            theme: "custom",
            content: '<img style="width:80px;" src="{{ URL::to(' / ').' / public / resources / img / company_logo.png ' }}" class="center-block">',
            message: "Please wait a while",
            backgroundColor: "#212230"
        };
        $('#swalbtn').click(function() {
            var url = $('#givenUrl').val();
            var validUrl = ValidURL(url);
            @if(Auth::user())
            var userId = {
                {
                    Auth::user() - > id
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
                    });
                } else {
                    var errorMsg = "Enter A Valid URL";
                    swal({
                        title: null,
                        text: errorMsg,
                        type: "error",
                        html: true
                    });
                }
            } else {
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
                return false;
            } else {
                return true;
            }
        }

        //previous functions here
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
<script type="text/javascript" src="{{url('/')}}/public/js/jquery.flexisel.js"></script>
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

</html>