<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="https://tier5.us/images/favicon.ico">
    <title>Tier5 | URL Shortener | Brand</title>
    <meta name="description" content="A free URL shortner brought to you by Tier5 LLC." />
    <meta name="keywords" content="Tier5 URL Shortner, Tr5.io, Tier5" />
    <meta name="author" content="Tier5 LLC" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/animate.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/custom.css" />
    <link rel="stylesheet" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/creditCardTypeDetector.css" />
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
    {{--
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <style>
    body {
        font-family: 'Nunito';
    }
    </style>
</head>

<body>
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- open/close -->
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="logo">
                        <a href="{{ route('getIndex') }}">
                            <img id="tier5_us" src="{{ URL('/')}}/public/resources/img/company_logo.png" alt="img" />
                        </a>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 header-right">
                    <div class="menu-icon">
                        <span id="hamburger" class="sidebar" aria-hidden="false" data-action="open" data-side="right">
                            <i class="fa fa-bars"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div id="myNav" class="sidebar right">
            <span id="cross" class="closebtn"><i class="fa fa-times"></i></span>
            <div class="overlay-content">
                <a href="{{ route('getLogout') }}">
                    <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-sign-out"></i>Sign out</button>
                </a>
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-email">{{ $user->email }}</div>
                <a href="{{ route('getDashboard') }}">
                    <button type="button" class="btn btn-success btn-sm"><i class="fa fa-upgrade"></i>Dashboard</button>
                </a>
            </div>
        </div>
    </header>
    <section class="hero">
        <section class="main-content">
            <div class="container">
                <form class="form" role="form" action="{{ route('postBrand') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="url_id" value="126" />
                    <div class="form-group">
                        <label for="brandLogo">Your Brand's Image: </label>
                        <input type="file" id="brandLogo" name="brandLogo" class="form-control input-md" style="padding-bottom: 40px;" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Upload</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
    <script src="http://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>
    <script>
        $(document).ready(function () {
            $('#hamburger').on('click', function () {
                $('.sidebar.right').addClass('open', true);
                $('.sidebar.right').removeClass('close', true);
            });
            $('#cross').on('click', function () {
                $('.sidebar.right').toggleClass('close', true);
                $('.sidebar.right').removeClass('open', true);
            });
        });
    </script>
    @if (Session::has('success'))
        <script>
            $(document).ready(function(){
                swal({
                    title: "Success",
                    text: "{{Session::get('success')}}",
                    type: "success",
                    html: true
                }); 
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            $(document).ready(function(){
                swal({
                    title: "Error",
                    text: "{{ $errors->first('brandLogo') }}",
                    type: "error",
                    html: true
                }); 
            });
        </script>
    @endif
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
</body>

</html>

