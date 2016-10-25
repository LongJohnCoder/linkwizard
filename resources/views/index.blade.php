<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="https://tier5.us/images/favicon.ico">
    <title>Tier5 | URL Shortener</title>
    <meta name="description" content="A free URL shortner brought to you by Tier5 LLC." />
    <meta name="keywords" content="Tier5 URL Shortner, Tr5.io, Tier5" />
    <meta name="author" content="Tier5 LLC" />
    <!-- Bootstrap -->
    <script src="{{ URL::to('/').'/public/resources/js/modernizr.custom.js' }}"></script>
    <link href="{{ URL::to('/').'/public/resources/css/bootstrap.min.css'}}" rel="stylesheet" />
    <link href="{{ URL::to('/').'/public/resources/css/jquery.fancybox.css'}}" rel="stylesheet" />
    <link href="{{ URL::to('/').'/public/resources/css/animate.css'}}" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css' />
    <link href="{{ URL::to('/').'/public/resources/css/styles.css'}}" rel="stylesheet" />
    <link href="{{ URL::to('/').'/public/resources/css/queries.css'}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css" />
    <link rel="stylesheet" type="text/css" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css" />
    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
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
                                <input id="givenUrl" class="myInput" type="text" name="">
                            </div>
                            <div class="col-sm-4">
                                <a id="swalbtn" style="cursor:pointer" class="learn-btn animated fadeInUp">Shorten Url</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <p>&copy; Tier5 {{ date('Y') }} - Designed &amp; Developed by <a href="http://www.tier5.us/">Tier5</a></p>
                </div>
                <div class="col-md-4"></div>
            </div>
        </section>
    </header>
    <div class="overlay overlay-boxify">
        <nav>
            <ul>
                @if (Auth::user())
                <li>
                    <a href="{{ route('getDashboard') }}">
                        <i class="fa fa-tachometer"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('getLogout') }}">
                        <i class="fa fa-sign-out"></i>Logout
                    </a>
                </li>
                @else
                <li>
                    <a href="#signin" data-toggle="modal" id="loginButton" data-target=".bs-modal-md">
                        <i class="fa fa-user"></i>Login
                    </a>
                </li>
                <li>
                    <a href="#signup" data-toggle="modal" id="registerButton" data-target=".bs-modal-md">
                        <i class="fa fa-sign-in"></i>Register
                    </a>
                </li>
                @endif
                <li>
                    <a target="_blank" href="https://tier5.us/">
                        <i class="fa fa-desktop"></i>Visit Our Website
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="mySmallModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade bs-modal-md in">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <br />
                <div class="bs-example bs-example-tabs">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a data-toggle="tab" style="color: #284666;" id="signInTab" href="#signin">Sign In</a></li>
                        <li class=""><a data-toggle="tab" style="color: #284666;" id="signUpTab" href="#signup">Register</a></li>
                        <li class=""><a data-toggle="tab" style="color: #284666;" id="whyUsTab" href="#why">Why?</a></li>
                    </ul>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="myTabContent">
                        <div id="why" class="tab-pane fade">
                            <p>By registering to our site you can track your list of shortend urls. Also you could monitor no of clicks, hits, and statistics of each and every single urls. Rest assured your information will not be sold, traded, or given to anyone.</p>
                            <p> Please contact
                                <a mailto:href="hello@tier5.us"></a>hello@tier5.us for any other inquiries.</p>
                        </div>
                        <div id="signin" class="tab-pane fade active in">
                            <form method="post" action="{{ route('postLogin') }}">
                                <fieldset>
                                    <!-- Sign In Form -->
                                    <!-- Text input-->
                                    <div class="control-group">
                                        <label for="useremail" class="control-label">Email:</label>
                                        <div class="controls">
                                            <input type="email" placeholder="johndoe@company.io" class="form-control" name="useremail" id="useremail">
                                        </div>
                                        @if($errors->any())
                                        <div id="useremailValidation" style="color:red">{{ $errors->first('useremail') }}</div>
                                        @endif
                                    </div>
                                    <!-- Password input-->
                                    <div class="control-group">
                                        <label for="passwordlogin" class="control-label">Password:</label>
                                        <div class="controls">
                                            <input type="password" placeholder="itsasecret" class="form-control" name="passwordlogin" id="passwordlogin">
                                        </div>
                                        @if($errors->any())
                                        <div id="passwordloginValidation" style="color:red">{{ $errors->first('passwordlogin') }}</div>
                                        @endif
                                    </div>
                                    <!-- Multiple Checkboxes (inline) -->
                                    <div class="control-group">
                                        <div class="controls">
                                            <label for="remember_me" class="checkbox inline">
                                                <input type="checkbox" value="true" id="remember_me" name="remember"> Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Button -->
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                            <button class="btn btn-primary" name="signin" style="background:#284666; color: #fff;" type="submit" id="signinButton">Sign In</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div id="signup" class="tab-pane fade">
                            <form method="post" action="{{ route('postRegister') }}">
                                <fieldset>
                                    <!-- Sign Up Form -->
                                    <!-- Text input-->
                                    <div class="control-group">
                                        <label for="Name" class="control-label">Name:</label>
                                        <div class="controls">
                                            <input type="text" placeholder="John Doe" class="form-control" name="name" id="Name">
                                        </div>
                                        @if($errors->any())
                                        <div id="NameValidation" style="color:red">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    <!-- Text input-->
                                    <div class="control-group">
                                        <label for="Email" class="control-label">Email:</label>
                                        <div class="controls">
                                            <input type="email" placeholder="johndoe@company.io" class="form-control" name="email" id="Email">
                                        </div>
                                        @if($errors->any())
                                        <div id="EmailValidation" style="color:red">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <!-- Password input-->
                                    <div class="control-group">
                                        <label for="password" class="control-label">Password:</label>
                                        <div class="controls">
                                            <input type="password" placeholder="itsasecret" class="form-control" name="password" id="password">
                                        </div>
                                        @if($errors->any())
                                        <div id="passwordValidation" style="color:red">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                    <!-- Text input-->
                                    <div class="control-group">
                                        <label for="password_confirmation" class="control-label">Confirm Password:</label>
                                        <div class="controls">
                                            <input type="password" placeholder="itsasecret" name="password_confirmation" class="form-control" id="password_confirmation">
                                        </div>
                                        @if($errors->any())
                                        <div id="password_confirmationValidation" style="color:red">{{ $errors->first('password_confirmation') }}</div>
                                        @endif
                                    </div>
                                    <!-- Multiple Radios (inline) -->
                                    <div class="control-group">
                                        <label for="humancheck" class="control-label">Humanity Check:</label>
                                        <div class="controls">
                                            {!! Recaptcha::render() !!}
                                        </div>
                                        @if($errors->any())
                                        <div id="humancheckValidation" style="color:red">{{ $errors->first('g-recaptcha-response') }}</div>
                                        @endif
                                    </div>
                                    <!-- Button -->
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                            <button class="btn btn-primary" type="submit" style="background:#284666; color: #fff;" id="confirmsignup">Sign Up</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <button data-dismiss="modal" class="btn btn-default" style="background:#284666; color: #fff;" type="button">Close</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
    <script src="{{ URL::to('/').'/public/resources/js/min/toucheffects-min.js'}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
    @if($errors->any())
    <script type="text/javascript">
    $(document).ready(function() {
        swal({
            title: "Error",
            text: "Please provide accurate information.",
            type: "error",
            html: true
        });
    });

    </script>
    @endif @if(Session::has('error'))
    <script type="text/javascript">
    $(document).ready(function() {
        swal({
            title: "Error",
            text: "{{Session::get('error')}}",
            type: "error",
            html: true
        });
    });

    </script>
    @endif @if(Session::has('success'))
    <script type="text/javascript">
    $(document).ready(function() {
        swal({
            title: "Success",
            text: "{{Session::get('success')}}",
            type: "success",
            html: true
        });
    });

    </script>
    <div class="alert alert-success"><strong>Success!</strong> {{Session::get('success')}}
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
    @endif
    <script type="text/javascript">
    $(document).ready(function() {
        $('#loginButton').click(function() {
            $('.nav-toggle').click();
            $('#myModal').modal('show');
            $('#signInTab').click(function() {
                $(this).tab('show');
            });
            $('#signUpTab').click(function() {
                $(this).tab('show');
            });
            $('#whyUsTab').click(function() {
                $(this).tab('show');
            });
        });

        $('#registerButton').click(function() {
            $('.nav-toggle').click();
            $('#myModal').modal('show');
            $('#signUpTab').click(function() {
                $(this).tab('show');
            });
            $('#signInTab').click(function() {
                $(this).tab('show');
            });
            $('#whyUsTab').click(function() {
                $(this).tab('show');
            });
        });

        $('#useremail').on('blur', function() {
            emailInput = $(this).val();
            emailRegex = new RegExp('^([a-zA-Z0-9-_\.])+@([a-z0-9]+[\.]+[a-z]{2,}([\.]*[a-z]){0,2})?$');
            if (emailInput == null) {
                $(this).focus();
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Email field should not be blank.</span>");
                return false;
            } else if (!emailRegex.test(emailInput)) {
                $(this).focus();
                $(this).parent().append("<span id='useremailValidation' style='color: red'>Please enter a valid email address.</span>");
                return false;
            } else {
                return true;
            }
        });

        $('#useremail').on('focus', function() {
            $('#useremailValidation').remove('#useremailValidation');
        });

        $('#passwordlogin').on('blur', function() {
            passwordInput = $(this).val();
            if (passwordInput == null) {
                $(this).focus();
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Password field should not be blank.</span>");
                return false;
            } else {
                return true;
            }
        });

        $('#passwordlogin').on('focus', function() {
            $('#passwordloginValidation').remove('#passwordloginValidation');
        });

        $('#Name').on('blur', function(e) {
            nameRegex = new RegExp('^([a-zA-Z\. ]){2,}$');
            nameInput = $(this).val();
            if (nameInput == null) {
                $(this).focus();
                $(this).parent().append("<span id='NameValidation' style='color: red'>Name field should not be blank.</span>");
                return false;
            } else if (!nameRegex.test(nameInput)) {
                $(this).focus();
                $(this).parent().append("<span id='NameValidation' style='color: red'>Please enter a valid name. Name should contain letters and space.</span>");
                return false;
            } else {
                return true;
            }
        });

        $('#Name').on('focus', function() {
            $('#NameValidation').remove('#NameValidation');
        });

        $('#Email').on('blur', function () {
            emailInput = $(this).val();
            emailRegex = new RegExp('^([a-zA-Z0-9-_\.])+@([a-z0-9]+[\.]+[a-z]{2,}([\.]*[a-z]){0,2})?$');
            if (emailInput == null) {
                $(this).focus();
                $(this).parent().append("<span id='EmailValidation' style='color: red'>Email field should not be blank.</span>");
                return false;
            } else if (!emailRegex.test(emailInput)) {
                $(this).focus();
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
                            $('#Email').parent().append("<span id='EmailValidation' style='color: red'>This email is already registered.</span>");
                            return false;
                        } else {
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
                return true;
            }
        });

        $('#Email').on('focus', function() {
            $('#EmailValidation').remove('#EmailValidation');
        });

        $('#password').on('blur', function() {
            passwordRegex =  new RegExp('(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#%^&*_+\-=?\.]).{8,}');
            passwordInput = $(this).val();
            if (passwordInput == null) {
                $(this).focus();
                $(this).parent().append("<span id='passwordValidation' style='color: red'>Password field should not be blank.</span>");
                return false;
            } else if (!passwordRegex.test(passwordInput)) {
                $(this).focus();
                $(this).parent().append("<span id='passwordValidation' style='color: red'>Password should be atleast eight characters long and contain one lowercase, one uppercase, one numeric and one special character.</span>");
                return false;
            } else {
                return true;
            }
        });

        $('#password').on('focus', function() {
            $('#passwordValidation').remove('#passwordValidation');
        });

        $('#password_confirmation').on('blur', function() {
            password_confirmationRegex =  new RegExp('(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#%^&*_+\-=?\.]).{8,}');
            password_confirmationInput = $(this).val();
            passwordInput = $('#password').val();
            if (password_confirmationInput == null) {
                $(this).focus();
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Confirm password field should not be blank.</span>");
                return false;
            } else if (!password_confirmationRegex.test(password_confirmationInput)) {
                $(this).focus();
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Password should be atleast eight characters long and contain one lowercase, one uppercase, one numeric and one special character.</span>");
                return false;
            } else if (passwordInput !== password_confirmationInput) {
                $(this).focus();
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Password and confirm password should match.</span>");
                return false;
            } else {
                return true;
            }
        });

        $('#password_confirmation').on('focus', function() {
            $('#password_confirmationValidation').remove('#password_confirmationValidation');
        });

        $('#humancheck').on('click', function () {
            humancheckInput = $(this).val();
            if (humancheckInput == null) {
                $(this).focus();
                $(this).parent().append("<span id='humancheckValidation' style='color: red'>Prove that you are not a robot!</span>");
                return false;
            }  else {
                return true;
            }
        });

        $('#humancheck').on('focus', function () {
            $('#humancheckValidation').remmove('#humancheckValidation');
        });

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

        function ValidURL(str) {
            var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|ac|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
            var url = str;
            if (!regexp.test(url)) {
                return false;
            } else {
                return true;
            }
        }
    });

    </script>
    <script src="{{ URL::to('/').'/public/resources/js/jquery.fancybox.pack.js' }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ URL::to('/').'/public/resources/js/retina.js' }}"></script>
    <script src="{{ URL::to('/').'/public/resources/js/waypoints.min.js' }}"></script>
    <script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js' }}"></script>
    <script src="{{ URL::to('/').'/public/resources/js/min/scripts-min.js' }}"></script>
    <script src="http://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
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
    <script>
        $(document).ready(function(){
            $("#registerButton").click(function(){
               $("#signUpTab").click(); 
            });
            $("#loginButton").click(function(){
               $("#signInTab").click(); 
            });
        });
    </script>
</body>

</html>

