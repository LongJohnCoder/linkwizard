<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width,maximum-scale=1,user-scalable=no,minimal-ui">
            <link href="{{url('/')}}/public/loader/css/bootstrap.min.css" rel="stylesheet">
            <link href="{{url('/')}}/public/loader/css/style.css" rel="stylesheet">
            <link rel="icon" type="image/jpg" href="{{$favicon}}" sizes="16x16">
            <script src="{{url('/')}}/public/loader/js/jquery.min.js"></script>
            <script src="{{url('/')}}/public/loader/js/bootstrap.min.js"></script>
            <meta name="robots" content="noindex,nofollow" />
            @if(strlen($url->title) > 0)
                <title>{{$url->title}}</title>
            @endif
            @if(strlen($url->meta_description) > 0)
                <meta name="description" content="{{$url->meta_description}}">
            @endif
            @if(strlen($url->og_title) > 0)
                <meta property="og:title" content="{{$url->og_title}}" />
            @endif
            @if(strlen($url->og_description) > 0)
                <meta property="og:description" content="{{$url->og_description}}" />
            @endif
            @if(strlen($url->og_image) > 0)
                <meta property="og:image" content="{{$url->og_image}}" />
            @endif
            @if(strlen($url->twitter_image) > 0)
                <meta name="twitter:title" content="{{$url->twitter_image}}" />
            @endif
            @if(strlen($url->twitter_description) > 0)
                <meta name="twitter:description" content="{{$url->twitter_description}}" />
            @endif
            @if(strlen($url->twitter_image) > 0)
                <meta name="twitter:image" content="{{$url->twitter_image}}" />
            @endif
            <meta name="twitter:card" content="summary"  />
            <link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css" />
            <link rel="stylesheet" type="text/css" href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' />
            <style type="text/css">
            body {
                font-family: 'Nunito';
                background: #fff !important;
            }
            .header{
                padding: 20px;
                background: {{$pageColor}};
                width: 100%;
                height: 50px;
            }
            .sticky-foot{
                /*padding: 20px;*/
                background: {{$pageColor}};
                width: 100%;
                /*bottom: 0px;*/
                /*position: fixed;*/
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: 50px;
            }
            .image-div,.production-div{
                padding: 20px;
                width: 100%;
                height: auto;
                text-align: center;
                align-items: middle;
            }
            .image-div img{
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            .blank-body{
                background-color: #fff;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
       <!-- PIXEL SCRIPT FOR HEADER STARTS HERE -->
        @if(isset($pixelScripts) && count($pixelScripts)>0)
            @foreach($pixelScripts as $key => $pixelScript)
                @if($pixelScripts[$key]==0)
                    {!! $pixelScript !!}
                @endif
            @endforeach
        @endforeach
        <!-- PIXEL SCRIPTS FOR HEADER ENDS HERE -->
    </head>
    <body>
        <div class="redirect-body-content">
            <div class="header"></div>
            <div class="row">
                <div class="col-md-12 col-lg-12 image-div">
                    @if(isset($imageUrl) && ($imageUrl!=""))
                        <img src="{{url('/')}}/{{$imageUrl}}" class="img-responsive">
                    @endif
                </div>
                <div class="col-md-12 col-lg-12 production-div">
                    @if(isset($redirectionText) && ($redirectionText!=""))
                        <span class="text">{{$redirectionText}}</span>
                    @endif
                    @if(isset($red_time) && ($red_time >0))
                        in <span id="txt_" style="display: inline;">{{$red_time / 1000 }}</span> sec  <p id="msg" style="color: #9f3a38;"></p>
                    @endif
                </div>
            </div>
            <div class="sticky-foot"></div>
        </div>
           
        <!-- PIXEL SCRIPT FOR FOOTER STARTS HERE -->
        @if(isset($pixelScripts) && count($pixelScripts)>0)
            @foreach($pixelScripts as $key => $pixelScript)
                @if($pixelScripts[$key]==1)
                    {!! $pixelScript !!}
                @endif
            @endforeach
        @endif
        <!-- PIXEL SCRIPTS FOR FOOTER ENDS HERE -->

        {{--  redirecting js script  --}}
        <script type="text/javascript">
            $(document).ready(function() {
                        var sec = '{{$red_time}}' / 1000;
                        window.setInterval(function(){
                            sec--;
                            if(sec >= 0){
                                $('#txt_').text(sec.toString());
                            }
                            else{
                                $('#txt_').text('');
                            }
                        }, 1000);
                $.ajax({
                    //url: '//freegeoip.net/json/',
                    url: '{{ env('GEO_LOCATION_API_URL') }}',
                    type: 'POST',
                    success: function(jsonData) {
                        var location = {
                            "ip" : jsonData.ip,
                            "country_code" : jsonData.country,
                            "country_name" : jsonData.country_name,
                            "region_code" : jsonData.region_code,
                            "region_name" : jsonData.region,
                            "city" : jsonData.city,
                            "zip_code" : jsonData.postal,
                            "time_zone" : jsonData.timezone,
                            "latitude" : jsonData.latitude,
                            "longitude" : jsonData.longitude,
                            "metro_code" : "",
                        }
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('postUserInfo') }}",
                            data: {
                                @if($url->link_type==2)
                                    url: '{{$sublink}}',
                                @else
                                    url: '{{ $url->id }}',
                                @endif
                                country: location,
                                querystring: '{{$_SERVER['QUERY_STRING']}}',
                                platform: '{{ $user_agent['platform'] }}',
                                browser: '{{ $user_agent['browser'] }}',
                                referer: '{{ $referer }}',
                                suffix : '{{ $suffix}}',
                                _token:  '{{ csrf_token() }}'
                            },
                            success: function(response){
                                setTimeout(function() {
                                    if (response.redirectstatus==0) {
                                        window.location.href=response.redirecturl;
                                    } else {
                                        $('#msg').text(response.message);
                                    }
                                }, {{$red_time}});
                            }
                        });
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
    </body>
</html>
