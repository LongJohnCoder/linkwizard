@php

        if(!empty($url->favicon) && strlen($url->favicon)>0)
        {
            $favicon = $url->favicon;
            $faviconPath = $favicon;
        }
        else
        {
            $external_file = $url->protocol.'://'.$url->actual_url;
            $headers = get_headers($external_file);
            if(preg_match("|200|", $headers[0]))
            {
                $favicon = getFavicon($external_file);
                $actualUrl = getDomainName($url->actual_url);
                $faviconPath = $url->protocol.'://'.$actualUrl.'/'.$favicon;
                if (@getimagesize($faviconPath)===false)
                {
                    $faviconPath = 'https://tier5.us/images/favicon.ico';
                }
            } else
            {
                $faviconPath = 'https://tier5.us/images/favicon.ico';
            }

        }

        function getDomainName($url)
        {
            if (strpos($url, '/'))
            {
                $endsUrl = substr($url,-1,1);
                if($endsUrl!='/')
                {
                    $explodedUrl = explode('/', $url);
                    if (count($explodedUrl)>0)
                    {
                        $actualUrl = $explodedUrl[0];
                    }
                }
                else
                {
                    $explodedUrl = explode('/', $url ,-1);
                    if (count($explodedUrl)>0)
                    {
                        $actualUrl = $explodedUrl[0];
                    }
                }
            }
            else
            {
                $actualUrl = $url;
            }

            return $actualUrl;
        }


        function getFavicon($url)
        {
            $favicon = '';
            $html = file_get_contents($url);
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_use_internal_errors(false);
            $links = $dom->getElementsByTagName('link');
            for ($i = 0; $i < $links->length; $i++){
                $link = $links->item($i);
                if($link->getAttribute('rel') == 'icon' or $link->getAttribute('rel') == 'show icon' or $link->getAttribute('rel') == 'Show Icon' or $link->getAttribute('rel') == 'shortcut icon'){
                    $favicon = $link->getAttribute('href');
                }
            }
            if(substr($favicon, 0,1)=='/')
            {
                $favicon = substr($favicon, 1);
            }
            elseif(preg_match("~^(?:f|ht)tps?://~i", $favicon))
            {
                $explodedFavICon = explode('://', $favicon);
                $actualImage = explode('/',$explodedFavICon[1]);
                $favicon = $actualImage[count($actualImage)-1];
            }
            else
            {
                $favicon = $favicon;
            }
            return $favicon;
        }
@endphp
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,maximum-scale=1,user-scalable=no,minimal-ui">
        <link href="{{url('/')}}/public/loader/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{url('/')}}/public/loader/css/style.css" rel="stylesheet">
        <link rel="icon" type="image/jpg" href="{{$faviconPath}}" sizes="16x16">
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
       <!-- PIXEL SCRIPT FOR HEADER STARTS HERE -->
    <?php
        if(isset($pixelScripts) && count($pixelScripts)>0)
        {
            foreach($pixelScripts as $key => $pixelScript)
            {
                if($scriptPosition[$key]==0)
                {
                    echo $pixelScript;
                }
            }
        }
    ?>
        <!-- PIXEL SCRIPTS FOR HEADER ENDS HERE -->
    </head>
    <body>
        @php
            $user_agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);
            $referer = $_SERVER['HTTP_HOST'];
            $requestIp = json_decode(file_get_contents(env('IP_API_URL')));
            $ipAddress = $requestIp->ip;
            $geoLocationApiUrl = env('GEO_LOCATION_API_URL').''.$ipAddress;
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

        <!-- PIXEL SCRIPT FOR FOOTER STARTS HERE -->
        <?php
        if(isset($pixelScripts) && count($pixelScripts)>0)
        {
            foreach($pixelScripts as $key => $pixelScript)
            {
                if($scriptPosition[$key]==1)
                {
                    echo $pixelScript;
                }
            }
        }
        ?>
        <!-- PIXEL SCRIPTS FOR FOOTER ENDS HERE -->

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
                                url: '{{ $url->id }}',
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
                                        window.location.href =response.redirecturl;
                                    } else {
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
