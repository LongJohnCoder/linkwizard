<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,maximum-scale=1,user-scalable=no,minimal-ui">
        <link href="{{url('/')}}/public/loader/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{url('/')}}/public/loader/css/style.css" rel="stylesheet">
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
                min-height: 100%;
                background: #fff !important;
            }
            .header{
                padding: 20px;
                background: #01579b;
                width: 100%;
            }
            .sticky-foot{
                padding: 20px;
                background: #01579b;
                width: 100%;
                bottom: 0px;
                position: fixed;
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
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
        @if(isset($url_features))
            @if($url_features->fb_pixel_id != null)
                @php
                    $fb_pixel_id = $url_features->fb_pixel_id;
                @endphp
                <!-- Facebook Pixel Code -->
                    <script>
                        !function(f,b,e,v,n,t,s)
                        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                            n.queue=[];t=b.createElement(e);t.async=!0;
                            t.src=v;s=b.getElementsByTagName(e)[0];
                            s.parentNode.insertBefore(t,s)}(window, document,'script',
                            'https://connect.facebook.net/en_US/fbevents.js');
                        fbq('init', '{{$fb_pixel_id}}');
                        fbq('track', 'PageView');
                    </script>
                    <noscript>
                        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{$fb_pixel_id}}&ev=PageView&noscript=1"/>
                    </noscript>
                    <!-- End Facebook Pixel Code -->
            @endif

            @if($url_features->gl_pixel_id != null)
                @php
                    $gl_pixel_id = $url_features->gl_pixel_id;
                @endphp
                <!-- Google Analytics -->
                <script>
                    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
                    ga('create', '{{$gl_pixel_id}}', 'auto');
                    ga('send', 'pageview');
                </script>
                <script async src='https://www.google-analytics.com/analytics.js'></script>
                <!-- End Google Analytics -->
            @endif
        @endif
    </head>
    <body>

        @php
            $user_agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);
            if (isset($_SERVER['HTTP_REFERER'])) {
                $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
            } else {
                $referer = parse_url("{{ route('getIndex') }}", PHP_URL_HOST);
            }
        @endphp
        <div class="header"></div>
        <div class="row">
            <div class="col-md-12 col-lg-12 image-div">
                @if($url->uploaded_path)
                    <img src="{{url('/')}}/{{$url->uploaded_path}}" class="img-responsive">
                @else
                    <img src="{{url('/')}}/public/images/Tier5.jpg" class="img-responsive">
                @endif
            </div>
            <div class="col-md-12 col-lg-12 production-div">
                @if($url->redirecting_text_template)
                    <span class="text"><?php echo($url->redirecting_text_template)?></span>
                @else
                    <span class="text">Please wait a snap while we take you to the actual website</span>
                @endif
                in <span id="txt_" style="display: inline;">{{$url->redirecting_time / 1000 }}</span> sec
                <p id="msg" style="color: #9f3a38;"></p>
            </div>
        </div>
        <div class="sticky-foot"></div>
        {{--  redirecting js script  --}}
        <script type="text/javascript">
            $(document).ready(function() {
                var sec = '{{$url->redirecting_time}}' / 1000;
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
                    url: '//freegeoip.net/json/',
                    type: 'POST',
                    dataType: 'jsonp',
                    success: function(location) {
                        //console.log(location);
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('postUserInfo') }}",
                            data: {
                                url: '{{ $url->id }}',
                                country: location,
                                platform: '{{ $user_agent['platform'] }}',
                                browser: '{{ $user_agent['browser'] }}',
                                referer: '{{ $referer }}',
                                suffix : '{{ $suffix}}',
                                _token:  '{{ csrf_token() }}'
                            },
                            success: function(response){
                                setTimeout(function() {
                                    if(response.redirectstatus==0){
                                        window.location.href =response.redirecturl;
                                    }else{
                                        $('#msg').text(response.message);
                                    }
                                }, "{{ $url->redirecting_time }}");
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