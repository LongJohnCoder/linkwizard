<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/png" href="https://tier5.us/images/favicon.ico">
        <title>Tier5 | URL Shortner | User Dashboard</title>
        <meta name="description" content="A free URL shortner brought to you by Tier5 LLC." />
        <meta name="keywords" content="Tier5 URL Shortner, Tr5.io, Tier5" />
        <meta name="author" content="Tier5 LLC" />
        <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap.min.css" />
        <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' />
        <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css" />
        <link rel="stylesheet" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css" />
        <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/custom.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
        <script src="https://www.gstatic.com/charts/loader.js"></script> 
        <script src="https://www.google.com/jsapi"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="{{ URL::to('/').'/public/resources/js/modernizr.custom.js' }}"></script>
        <!-- Facebook and Twitter integration -->
        <meta property="og:title" content=""/>
        <meta property="og:image" content=""/>
        <meta property="og:url" content=""/>
        <meta property="og:site_name" content=""/>
        <meta property="og:description" content=""/>
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
                        <div class="menu-icon">
                            <button id="tr5link" class="btn btn-danger">CREATE TR5LINK</button>
                        </div>
                        <div class="search-part"> 
                            <form action="" class="search-form">
                                <div class="form-group has-feedback">
                                    <input type="text" class="form-control" name="search" id="search" placeholder="SEARCH" />
                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="myNav" class="sidebar right">
                <span id="cross" class="closebtn"><i class="fa fa-times"></i></span>
                <div class="overlay-content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <a href="{{ route('getLogout') }}">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-sign-out"></i>Sign out</button>
                            </a>
                            <div class="profile-name">{{ $user->name }}</div>
                            <div class="profile-email">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="myNav1" class="tr5link">
                <span id="cross1" class="closebtn"><i class="fa fa-times"></i></span>
                <div class="overlay-content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <input id="givenUrl" class="myInput form-control" type="text" name="" placeholder="Paste Your URL Here">
                            <button id="swalbtn" type="submit" class="btn btn-primary btn-sm">Shorten Url</button>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="hero">
            <section class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <canvas id="myChart" height="50px"></canvas>
                    </div>
                </div>
            </section>
            <section class="main-content">
                <div class="texture-overlay"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                                <div class="list-group">
                                    @foreach ($urls as $url)
                                        <a href="#" class="list-group-item active">
                                            <span class="date">{{ $url->created_at }}</span>
                                            <span class="title">{{ $url->title }}</span>
                                            <span class="link">{{ $url->actual_url }}</span>
                                            <span class="count">{{ $url->count }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                                @foreach ($urls as $key => $url)
                                    <div class="bhoechie-tab-content {{ $key == 0 ? 'active' : null }}">
                                        <p class="date">{{ date('M d, Y', strtotime($url->created_at)) }}</p>
                                        <h1 class="title">{{ $url->title }}</h1>
                                        <h5><a href="http://{{ $url->actual_url }}">{{ $url->actual_url }}</a></h5>
                                        <h3><a href="{{ route('getIndex') }}/{{ $url->shorten_suffix }}" class="link">{{ route('getIndex') }}/{{ $url->shorten_suffix }}</a></h3>
                                        <div class="buttons">
                                            <a href="#">copy</a>
                                            <a href="#">share</a>
                                            <a href="#">edit</a>
                                        </div>
                                        <hr>
                                        <p class="count">{{ $url->count }} <i class="fa fa-signal"></i></p>
                                        <p class="count">TOTAL COUNTS</p>
                                        <div class="row" style="background-color: #ffffff">
                                            <div class="col-sm-6">
                                                <div id="chart_div{{ $key }}" style="width: 550px; height: 380px;"></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div id="regions_div{{ $key }}" style="width: 550px; height: 380px;"></div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            {!! $key == 0 ? "google.charts.load('current', {'packages':['corechart']});" : null !!}
                                            $.ajax({
                                                url: "{{ route('postHitCountry') }}",
                                                type: 'POST',
                                                data: {url_id: {{ $url->id }}, _token: "{{ csrf_token() }}"},
                                                success: function (response) {
                                                    if (response.status == "success") {
                                                        google.charts.setOnLoadCallback(function () {
                                                            var data = google.visualization.arrayToDataTable(response.location);
                                                            var options = { colorAxis: {colors: '#3366ff'}, background: 'rgba(255, 255, 255, 0.8)'  };
                                                            var chart{{ $key }} = new google.visualization.GeoChart(document.getElementById('regions_div{{ $key }}'));
                                                            chart{{ $key }}.draw(data, options);
                                                        });
                                                        google.charts.setOnLoadCallback(function () {
                                                            var data = google.visualization.arrayToDataTable(response.location);
                                                            var options = {
                                                              title: 'My Daily Activities',
                                                              pieHole: 0.4,
                                                            };
                                                            var chart{{ $key }} = new google.visualization.PieChart(document.getElementById('chart_div{{ $key }}'));
                                                            chart{{ $key }}.draw(data, options);
                                                        });
                                                    } else {
                                                     console.log('Response error!');
                                                    }
                                                }
                                            });
                                        </script>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
       <script src="{{ URL::to('/').'/public/resources/js/jquery.sidebar.min.js'}}"></script>
        <script>
            $(document).ready(function () {
                $('#hamburger').on('click', function () {
                    $('.sidebar.right').toggleClass('open', true);
                });
                $('#cross').on('click', function () {
                    $('.sidebar.right').toggleClass('close', true);
                });
                $('#tr5link').on('click', function () {
                    $('.tr5link').toggleClass('open', true);
                });
                $('#cross1').on('click', function () {
                    $('.tr5link').toggleClass('close', true);
                });
            });
        </script>
        <script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
        <script src="{{ URL::to('/').'/public/resources/js/min/toucheffects-min.js'}}"></script>
        <script>
            $(document).ready(function () {
                var options = {
                    message:"Please wait a while"
                };
                
                $('#swalbtn').click(function() {
                    var url = $('#givenUrl').val();
                    var validUrl = ValidURL(url);
                    @if (Auth::user())
                        var userId = {{ Auth::user()->id }};
                    @else
                        var userId = 0;
                    @endif
                    if(url) {
                        if(validUrl) {
                            HoldOn.open(options);
                            console.log(url);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('postShortUrlTier5') }}",
                                data: {url: url, user_id: userId, _token: "{{ csrf_token() }}"},
                                success: function (response) {
                                    if(response.status=="success") {
                                        console.log(response);
                                        var shortenUrl = response.url;
                                        var UrlWithLink = "<a href="+shortenUrl+">"+shortenUrl+"</a>";
                                        swal({
                                            title: "Shorten Url:",
                                            text: UrlWithLink,
                                            type: "success",
                                            html: true
                                        }); 
                                        HoldOn.close();
                                    } else {
                                        swal({
                                            title: "",
                                            text: "Response Error",
                                            type: "warning",
                                            html: true
                                        }); 
                                        HoldOn.close();
                                    }
                                }, error: function(response) {
                                    console.log(response);
                                    HoldOn.close();
                                }
                            });
                        } else {
                            var errorMsg="Enter A Valid URL";
                            swal({
                                title: "",
                                text: errorMsg,
                                type: "error",
                                html: true
                            }); 
                        }
                    } else {
                        var errorMsg="Please Enter An URL";
                        swal({
                            title: "",
                            text: errorMsg,
                            type: "warning",
                            html: true
                        });     
                    }
                });
                
                function ValidURL(str) {
                    var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
                    var url = str;
                    if (!regexp.test(url)) {
                        return false;
                    } else {
                        return true;
                    }
                }
            });
        </script>
        <script type="text/javascript">
        $(document).ready(function () {
            $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
        });
        </script>
        <script>
            dataset = {
                    labels: [
                        @foreach ($urls as $url)
                            '{{ route('getIndex') }}/{{ $url->shorten_suffix }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: "No of clicks",
                        data: [
                            @foreach ($urls as $url)
                                {{ $url->count }},
                            @endforeach
                        ],
                        backgroundColor: [
                        @foreach ($urls as $key => $url)
                            'rgba({{ 255-($key*25) }}, {{ 127-($key*33) }}, {{ 63+($key++*22) }}, 0.2)',
                        @endforeach
                    ],
                    borderColor: [
                        @foreach ($urls as $key => $url)
                            'rgba({{ 255-($key*3) }}, {{ 127-($key*17) }}, {{ 63+($key*25) }}, 1)',
                        @endforeach
                    ],
                    borderWidth: 1
                    }]
            };
            Chart.defaults.global.defaultFontColor =  '#fff';
            var myChart = new Chart(document.getElementById("myChart"), {
                type: 'bar',
                data: dataset,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        </script>
        <script type="text/javascript">
            $.ajax({
                url: '//freegeoip.net/json/',
                type: 'POST',
                dataType: 'jsonp',
                success: function (location) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('postStoreLocation') }}",
                        data: {location: location, _token: "{{ csrf_token() }}"},
                        success: function (response) {
                            if (response.status == "success") {
                                {{-- console.log(response.location.country_code); --}}
                            } else {
                                console.log('Response error!');
                            }
                        }
                    });
                }
            });
        </script>
        <script src="http://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>
        @if(Session::has('success'))
            <script type="text/javascript">
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
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>