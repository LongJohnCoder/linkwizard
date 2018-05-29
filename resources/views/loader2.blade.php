@php
    //dd($url->day_four);
    $user_agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);
    //dd($_SERVER);
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    } else {
        $referer = parse_url("{{ route('getIndex') }}", PHP_URL_HOST);
    }
    header("Access-Control-Allow-Origin: *");

    /* to check query string */
    $query_string = '0';
    $query_link = '';
    // is_expiry the status of the 1 = no expiry 2 = expiry with redirection
    $is_expire = 0;
    $redirect_url = '';
    // $is_schedule the flag to check whether the flag have any special schedule 1 = special 2 = weekly check and actual
    $is_schedule = 2;

    $check = 'someday';
    if(!empty($_SERVER['QUERY_STRING'])){
        $query_string = '1';
        $query_link = $_SERVER['QUERY_STRING'];
    }

    /* check if  url has expiry date */
    if(!empty($url->date_time))
    {
        date_default_timezone_set($url->timezone);
        $date1= date('Y-m-d H:i:s') ;
        $date2 = $url->date_time;
        if(strtotime($date1) < strtotime($date2)){
            /*Url Not Expired*/
            $is_expire = 1;

            /* LINK SCHEDULES for links have expiry */

            /* to check if there is any special schedule for this link */
            if ($url->is_scheduled =='y' && count($url->urlSpecialSchedules)>0)
            {
                foreach($url->urlSpecialSchedules as $spl_url)
                {
                    if($spl_url->special_day == date('Y-m-d'))
                    {
                        $is_schedule = 1;
                        $redirect_url = $spl_url->special_day_url;
                    }else
                    {
                        $is_schedule = 2;
                    }
                }
            }
            /* weekly schedule */
            if($is_schedule == 2)
            {
                if(date('N')=='1')
                {
                    if(!is_null($url->day_one))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_one;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='2')
                {
                    if(!is_null($url->day_two))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_two;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='3')
                {
                    if(!is_null($url->day_three))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_three;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='4')
                {
                    if(!is_null($url->day_four))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_four;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='5')
                {
                    if(!is_null($url->day_five))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_five;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='6')
                {
                    if(!is_null($url->day_six))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_six;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='7')
                {
                    if(!is_null($url->day_seven))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_seven;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }
                }
            }
        }else{
            /* Url Expired */
            $is_expire = 2;
            if(!is_null($url->redirect_url))
            {
                $redirect_url = $url->redirect_url;
            }
            else
            {
                $redirect_url = 'NULL'; /* default redirect page of expiry urls */
            }
        }
    }else
    {
        $is_expire = 1;
        /* LINK SCHEDULES for links have no expiry */
            /* to check if there is any special schedule for this link */
            if ($url->is_scheduled =='y' && count($url->urlSpecialSchedules)>0)
            {
                foreach($url->urlSpecialSchedules as $spl_url)
                {
                    if($spl_url->special_day == date('Y-m-d'))
                    {
                        $is_schedule = 1;
                        $redirect_url = $spl_url->special_day_url;
                    }else
                    {
                        $is_schedule = 2;
                    }
                }
            }
            /* weekly schedule */
            if($is_schedule == 2)
            {
                if(date('N')=='1')
                {
                    if(!is_null($url->day_one))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_one;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='2')
                {
                    if(!is_null($url->day_two))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_two;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='3')
                {
                    if(!is_null($url->day_three))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_three;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='4')
                {
                    if(!is_null($url->day_four))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_four;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='5')
                {
                    if(!is_null($url->day_five))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_five;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='6')
                {
                    if(!is_null($url->day_six))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_six;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }

                }
                if(date('N')=='7')
                {
                    if(!is_null($url->day_seven))
                    {
                        $is_schedule = 2;
                        $redirect_url = $url->day_seven;
                    }
                    else
                    {
                        $redirect_url = $url->protocol.'://'.$url->actual_url;
                    }
                }
            }
    }
@endphp
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

    {{--
    @if(strlen($url->og_url) > 0)
      <meta property="og:url" content="{{$url->og_url}}" />
    @endif
    --}}

    @if(strlen($url->og_image) > 0)
        <meta property="og:image" content="{{$url->og_image}}" />
    @endif

    @if(strlen($url->twitter_image) > 0)
        <meta name="twitter:title" content="{{$url->twitter_image}}" />
    @endif

    {{--
    @if(strlen($url->twitter_url) > 0)
      <meta name="twitter:url" content="{{$url->twitter_url}}" />
    @endif
    --}}

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
            width: 40%;
            height: auto;
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
    <div class="header"></div>
    <div class="row">

        <div class="col-md-12  col-lg-12 image-div" >
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
    var str = "{{$url->actual_url}}";
    if(str.indexOf('https://') >= 0 || str.indexOf('http://') >=0 ) {
        var URL_TO_REDIRECT = "{{$url->actual_url}}";
    } else {
        var URL_TO_REDIRECT = "{{$url->protocol}}"+'://'+"{{$url->actual_url}}";
    }

    /* Url for query string */
    if({{$query_string}}==1){
        URL_TO_REDIRECT = URL_TO_REDIRECT+"?"+"{{$query_link}}";
    }
    /* Actual url */
    if({{$query_string}}==0){
        URL_TO_REDIRECT = URL_TO_REDIRECT;
    }

    /* expiry redirection check */
    if({{$is_expire}}==2){
        URL_TO_REDIRECT = "{{$redirect_url}}";
    }

    /* non expiry, not expired, link scheduled redirection check */
    if({{$is_expire}}==1)
    {
        URL_TO_REDIRECT = "{{$redirect_url}}";
    }
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
                console.log(location);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('postUserInfo') }}",
                    data: {
                        url: '{{ $url->id }}',
                        country: location,
                        platform: '{{ $user_agent['platform'] }}',
                        browser: '{{ $user_agent['browser'] }}',
                        referer: '{{ $referer }}',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        console.log(response);
                        setTimeout(function() {
                            console.log(URL_TO_REDIRECT);
                            if(URL_TO_REDIRECT=='NULL')
                            {
                                $('#msg').text('Sorry! the link has been expired');
                            }
                            if(URL_TO_REDIRECT!='NULL')
                            {
                                window.location.replace(URL_TO_REDIRECT.replace(/&amp;/g, '&'));
                            }
                            HoldOn.close();
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
