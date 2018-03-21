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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/animate.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/custom.css" />
    <link rel="stylesheet" href="https://t4t5.github.io/sweetalert/dist/sweetalert.css" />
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
                            <img src="{{config('settings.SITE_LOGO')}}" alt="img" />
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>No of Limits</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($limits as $limit)
                        <tr>
                            <td>{{ $limit->plan_name }}</td>
                            <td>{{ $limit->limits }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" onclick="editLimitAction('{{ $limit->limits }}', '{{ $limit->id }}');">
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </section>
    <div class="modal fade bs-modal-sm in" id="editLimitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body" id="editModalBody">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -15px -10px">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form class="form-inline" method="post" action="{{ route('postPackageLimit') }}">
                            <div class="control-group">
                                <input type="text" name="limits" placeholder="No of Limits" class="form-control input-mg" id="limitLimits" style="width: 70%" value="" />
                                <button type="submit" class="btn btn-warning" id="limitLimits">Edit</button>
                                <input type="hidden" name="id" id="limitId" value="" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
    <script src="https://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>
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
    <script>
        function editLimitAction(noOfLimit, id) {
            $("#editModalBody #limitLimits").val(noOfLimit);
            $("#editModalBody #limitId").val(id);
            $('#editLimitModal').modal('show');
        }
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
    @elseif (Session::has('error'))
        <script>
            $(document).ready(function(){
                swal({
                    title: "Error",
                    text: "{{Session::get('error')}}",
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
