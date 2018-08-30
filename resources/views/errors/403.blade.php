<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="viewport" content="width=device-width,maximum-scale=1,user-scalable=no,minimal-ui">
    <title>Tier5 | URL Shortener | 404 URL Not Found</title>
    <meta name="description" content="A free URL shortner brought to you by Tier5 LLC." />
    <meta name="keywords" content="Tier5 URL Shortner, Tr5.io, Tier5" />
    <meta name="author" content="Tier5 LLC" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/custom.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    body {
        font-family: 'Nunito';
        text-align: center;
        color: white;
    }

    .button {
        background-color: transparent;
        /* Green */
        border: none;
        color: white;
        padding: 16px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        -webkit-transition-duration: 0.4s;
        /* Safari */
        transition-duration: 0.4s;
        cursor: pointer;
    }

    .button5 {
        color: #00AEEF;
        border: 2px solid #555555;
    }

    .button5:hover {
        background-color: #555555;
        color: white;
    }

    </style>
</head>

<body>
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- open/close -->
    <section class="hero">
        <section class="main-content">
            <h1 class="title" style="font-size: 250px;">403</h1>
            <h2 class="title">Forbidden</h2>
            <br>
            <a href="{{ route('getIndex') }}">
                <button type="button" class="button button5">Go Home</button>
            </a>
        </section>
    </section>
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
