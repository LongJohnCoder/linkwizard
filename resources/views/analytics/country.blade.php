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
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Lato:400,300,700' />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/animate.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/custom.css" />
    <link rel="stylesheet" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/creditCardTypeDetector.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.0-rc.2/Chart.bundle.min.js"></script>
    <script src="{{ URL::to('/').'/public/resources/js/highcharts.js' }}"></script>
    <script src="{{ URL::to('/').'/public/resources/js/highchart-data.js' }}"></script>
    <script src="{{ URL::to('/').'/public/resources/js/highchart-drilldown.js' }}"></script>
    <script src="http://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script> 
    <script src="https://www.google.com/jsapi"></script>
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
        font-family: 'Lato';
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
                            <img src="{{ URL('/')}}/public/resources/img/company_logo.png" alt="img" />
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
                <section class="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="columnChart" style="min-width: 310px; height: 165px; margin: 0 auto"></div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <section class="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container layout--wrapper">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab">
                                <div class="bhoechie-tab-content active">
                                    <p class="date">Advanced Analytics from {{ $country->name }}</p>
                                    <div class="row" style="background-color: #ffffff">
                                        <div class="col-sm-4">
                                            <div id="platform_div" style="width: 400px; height: 250px;"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="browser_div" style="width: 400px; height: 250px;"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="referral_div" style="width: 400px; height: 250px;"></div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        google.charts.load('current', {'packages':['corechart', 'geochart']});
                                        $.ajax({
                                            url: "{{ route('postAnalyticsByCountry') }}",
                                            type: 'POST',
                                            data: {url_id: {{ $url->id }}, country_id: {{ $country->id }}, _token: "{{ csrf_token() }}"},
                                            success: function (response) {
                                                if (response.status == "success") {
                                                    google.charts.setOnLoadCallback(function () {
                                                        var data = google.visualization.arrayToDataTable(response.platform);
                                                        var options = {
                                                            title: 'Platform Shares',
                                                            pieHole: 0.7,
                                                            width: 400,
                                                            height: 250,
                                                        };
                                                        var chart = new google.visualization.PieChart(document.getElementById('platform_div'));
                                                        chart.draw(data, options);
                                                    });
                                                    google.charts.setOnLoadCallback(function () {
                                                        var data = google.visualization.arrayToDataTable(response.browser);
                                                        var options = {
                                                            title: 'Browser Stats',
                                                            pieHole: 0.7,
                                                            width: 400,
                                                            height: 250,
                                                        };
                                                        var chart = new google.visualization.PieChart(document.getElementById('browser_div'));
                                                        chart.draw(data, options);
                                                    });
                                                    google.charts.setOnLoadCallback(function () {
                                                        var data = google.visualization.arrayToDataTable(response.referer);
                                                        var options = {
                                                            title: 'Referring Channels',
                                                            pieHole: 0.7,
                                                            width: 400,
                                                            height: 250,
                                                        };
                                                        var chart = new google.visualization.PieChart(document.getElementById('referral_div'));
                                                        chart.draw(data, options);
                                                    });
                                                } else {
                                                 console.log('Response error!');
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </section>
    <!-- JavaScripts -->
    <script>
    $(document).ready(function() {
        $('#hamburger').on('click', function() {
            $('.sidebar.right').addClass('open', true);
            $('.sidebar.right').removeClass('close', true);
        });
        $('#cross').on('click', function() {
            $('.sidebar.right').toggleClass('close', true);
            $('.sidebar.right').removeClass('open', true);
        });
    });

    </script>
    <script>
        $.ajax({
            type: 'post',
            url: '{{ route('postFetchChartDataByCountry') }}',
            data: {
                "user_id": {{ $user->id }},
                "url_id": {{ $url->id }},
                "country_id": {{ $country->id }},
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#columnChart').highcharts({
                    chart: {
                        type: 'column',
                        backgroundColor: 'rgba(255, 255, 255, 0)'
                    },
                    title: {
                        text: null
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            style: {
                                fontWeight: 'bold',
                                color: '#fff'
                            }
                        }
                    },
                    yAxis: {
                        labels: {
                            enabled: false
                        },
                        title: {
                            text: null
                        },
                        gridLineWidth: 0,
                        minorGridLineWidth: 0
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: false,
                                format: '{point.y:.1f}%'
                            }
                        }
                    },

                    tooltip: {
                        backgroundColor: '#fff',
                        borderWidth: 1,
                        borderRadius: 10,
                        borderColor: '#AAA',
                        headerFormat: null,
                        pointFormat: '<span style="color:{point.color}">{point.name}</span><br/>Total clicks: <b>{point.y:.0f}</b>'
                    },
                    series: [{
                        name: 'URLs',
                        colorByPoint: true,
                        //pointWidth: 28,
                        data: response.chartData
                    }],
                });
            },
            error: function(response) {
                console.log('Response error!');
            },
            statusCode: {
                500: function(response) {
                    console.log('500 Internal server error!');
                }
            }
        });
    </script>
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

