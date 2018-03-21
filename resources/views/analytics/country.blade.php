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
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Lato:400,300,700' />
    <link href="{{url('/')}}/public/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/animate.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/custom.css" />
    <link rel="stylesheet" href="https://t4t5.github.io/sweetalert/dist/sweetalert.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/creditCardTypeDetector.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.0-rc.2/Chart.bundle.min.js"></script>
    <script src="{{ URL::to('/').'/public/resources/js/highcharts.js' }}"></script>
    <script src="{{ URL::to('/').'/public/resources/js/highchart-data.js' }}"></script>
    <script src="{{ URL::to('/').'/public/resources/js/highchart-drilldown.js' }}"></script>
    <script src="https://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>
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
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- open/close -->

<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="logo">
                    <a href="{{url('')}}/about"><img src="{{url('/')}}/public/images/logo.png" class="img-responsive"></a>
                </div>
            </div>

            <div class="col-md-8">
                <div class="top-right">
                    
                    <div class="hamburg-menu">
                      <a href="#" id="menu-icon" class="menu-icon">
                        <div class="span bar top" style="background-color: #fff;"></div>
                        <div class="span bar middle" style="background-color: #fff;"></div>
                        <div class="span bar bottom" style="background-color: #fff;"></div>
                      </a>
                    </div>
                    <div id="userdetails" class="userdetails">
                        <div>
                            <a href="{{ route('getLogout') }}" class="signout"><i class="fa fa-sign-out"></i> Sign out</a>
                            <p style="color:white">{{ $user->name }}</p>
                            <p style="color:white">{{ $user->email }}</p>
                            
                        </div>
                    </div>

                    <div id="myNav1" class="userdetails">
                        <div class="overlay-content">
                            <div class="col-md-12 col-sm-12">
                                <label for="givenUrl" style="color:white">Paste An Actual URL Here</label>
                                <input id="givenUrl" class="myInput form-control" type="text" name="" placeholder="Paste Your URL Here">
                                <button id="swalbtn" type="submit" class="btn btn-primary btn-sm">
                                    Shorten Url
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="myNav2" class="userdetails">
                        <div class="overlay-content">
                            <div class="col-md-12 col-sm-12">
                                <label for="givenActualUrl" style="color:white;">Paste An Actual URL Here</label>
                                <input id="givenActualUrl" style="width:280px" class="myInput form-control" type="text" name="" placeholder="Paste Your URL Here">
                                <br>
                                <br>
                                <label for="makeCustomUrl" style="color:white">Create Your Own Custom Link</label>
                                <div class="input-group">
                                    <span class="input-group-addon">{{ env('APP_HOST') }}</span>
                                    <input id="makeCustomUrl" class="myInput form-control" type="text" name="" placeholder="e.g. MyLinK">
                                </div>
                                <button id="swalbtn1" type="submit" class="btn btn-primary btn-sm">
                                    Shorten Url
                                </button>
                                <br>
                                <span id="err_cust" style="color:red; display:none;" >This URL is taken. Please try with a different name</span>
                            </div>
                        </div>
                    </div>


                    <div class="top-menu dashboard-menu">
                        <div class="desktop-menu">
                            <ul>
                                <li><a href="/about">about</a></li>
                                <li><a href="/features">features</a></li>
                                <li><a href="/pricing">pricing</a></li>
                                <li><a href="/blog">blog</a></li>
                                @if ($user->is_admin == 1)
                                    <li><a style="color:green" href="{{ route('getAdminDashboard') }}">ADMIN DASHBOARD</a></li>
                                @endif
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
    <section class="hero">
        <section class="main-content">
            <div class="container">
                <section class="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="columnChart" style="height: 165px; margin: 0 auto"></div>
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
                                    <p class="date"  style="text-transform: none;">
                                        <span style="text-transform: uppercase;">Advanced Analytics from {{ $country->name }}</span>
                                        <a href="#" class="pull-right" style="margin: 10px 20px 0px 0px; text-decoration: none; border-bottom: 1px dashed;" data-toggle="tooltip" data-placement="bottom" title="All clicks data are reported in UTC to provide consistence data acrosss different timezones.">DATA IN UTC</a>
                                    </p>
                                    <div class="row" style="background-color: #ffffff">
                                        <div class="col-md-6">
                                            <div id="platform_div" class="each-section"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="browser_div" class="each-section"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="referral_div" class="each-section"></div>
                                        </div>
                                        <div class="col-md-6">
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
                                                            pieHole: 0.4,
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
                                                            pieHole: 0.4,
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
                                                            pieHole: 0.4,
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
<!--     <footer>
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
    </footer> -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="footer-menu">
                        <ul>
                            <li><a href="#">About1</a></li>
                            <li><a href="#">Features</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Partners</a></li>
                            <li><a href="#">Privacy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="social-icon">
                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                </div>

                </div>  

                </div>



                
                
            </div>



        </div>
    </div>
    <div class="copyright">
        <p>© All Rights Reserved to Tier5 LLC. </p>
    </div>


</footer>



    <!-- JavaScripts -->
    <script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
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
                //var chartDataStack = [];
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
                            },
                            events:{
                                click: function (event) {
                                    //var pointName = event.point.name;
                                    pushChartDataStack(event.point.name, response.url.shorten_suffix);
                                }
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
                function pushChartDataStack(data, url) {
                    //chartDataStack.push(data);
                    date = new Date(data);
                    month = date.getMonth()+1;
                    isoDate = date.getFullYear()+"-"+month+"-"+date.getDate();
                    window.location.href = "{{ url('/') }}/"+url+"/date/"+isoDate+"/analytics";
                }
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

<script type="text/javascript">

    $(document).ready(function() {

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
        });

        $("#advanced").click(function(){
            $('.menu-icon').addClass("close");
            $('#myNav2').slideToggle(500);
            $('#myNav1').hide();
            $('#userdetails').hide();
        });

        $(this).on('click', '.close', function(){
            $('.userdetails').hide();
            $(this).removeClass("close");
        });

        $('[data-toggle="tooltip"]').tooltip();
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
        
    });
</script>

</html>

