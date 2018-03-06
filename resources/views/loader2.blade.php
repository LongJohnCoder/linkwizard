
<?php

$user_agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);

if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
} else {
    $referer = parse_url("{{ route('getIndex') }}", PHP_URL_HOST);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width,maximum-scale=1,user-scalable=no,minimal-ui">
<title>Url Shortner</title>

<link href="{{url('/')}}/public/loader/css/bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/public/loader/css/style.css" rel="stylesheet">
<script src="{{url('/')}}/public/loader/js/jquery.min.js"></script>
<script src="{{url('/')}}/public/loader/js/bootstrap.min.js"></script>


    <meta name="robots" content="noindex,nofollow" />

    <title>@if(strlen($url->title) > 0){{$url->title}}@else{{'Tier5 | URL Shortener'}}@endif</title>


    @if(strlen($url->og_title) > 0)
    <!-- Title to display for fb open graph for destination url -->
      <meta property="og:title" content="{{$url->og_title}}" />
    @endif


    @if(strlen($url->og_description) > 0)
    <!-- description to display content for fb open graph for destination url -->
      <meta property="og:description" content="{{$url->og_description}}" />
    @endif


    @if(strlen($url->og_url) > 0)
    <!-- URL to display for fb open graph for destination url -->
      <meta property="og:url" content="{{$url->og_url}}" />
    @endif


    @if(strlen($url->og_image) > 0)
    <!-- URL to display for fb open graph for image -->
      <meta property="og:image" content="{{$url->og_image}}" />
    @endif


    @if(strlen($url->meta_description) > 0)
    <!-- meta description -->
      <meta name="description" content="{{$url->meta_description}}" />
    @endif

    <meta name="keywords" content="Tier5 URL Shortener, Tr5.io, Tier5" />
    <meta name="author" content="Tier5 LLC" />
    <!--
    <meta name="description" content="An URL shortener with more sophisticated analytics. Spread your business or creativity using the power of shorten links. Brought to you by Tier5 LLC." />
    -->

    <!--
    <meta property="og:title" content="Tier5 URL Shortener" />
    -->

    {{--<meta property="og:site_name" content="Tr5.io" />--}}
    <!--
    <meta property="og:url" content="tr5.io" />
    <meta property="og:description" content="An URL shortener with more sophisticated analytics. Spread your business or creativity using the power of shorten links. Brought to you by Tier5 LLC." />
    -->

    @if(strlen($url->twitter_image) > 0)
    <!-- Title to display for twitter for tittle -->
      <meta name="twitter:title" content="{{$url->twitter_image}}" />
    @endif

    @if(strlen($url->twitter_url) > 0)
    <!-- Title to display for twitter for destination url -->
      <meta name="twitter:url" content="{{$url->twitter_url}}" />
    @endif

    @if(strlen($url->twitter_description) > 0)
    <!-- Title to display for twitter for description -->
      <meta name="twitter:description" content="{{$url->twitter_description}}" />
    @endif

    @if(strlen($url->twitter_image) > 0)
    <!-- Title to display for twitter for image -->
      <meta name="twitter:image" content="{{$url->twitter_image}}" />
    @endif

    <meta name="twitter:card" content="summary"  />

    {{--<meta property="al:web:url" content="{{ $url->protocol }}://{{ $url->actual_url }}" />--}}
    <link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css" />
    <link rel="stylesheet" type="text/css" href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' />
    <style type="text/css">
    body {
        font-family: 'Nunito';
    }

    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
    <style type="text/css">
        body{
            background: #fff !important;
        }
    </style>
    @if(isset($url_features) && $url_features->fb_pixel_id != null)

    @php
      $pixel_id = $url_features->fb_pixel_id;
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
      fbq('init', '@php echo $pixel_id; @endphp');
      fbq('track', 'PageView');
      </script>
      <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=@php echo $pixel_id; @endphp&ev=PageView&noscript=1"
      /></noscript>
      <!-- End Facebook Pixel Code -->

    @endif
</head>
<body>


	<!-- Main Content Start -->
	<div class="container">
		<div class="centerdiv">
			<div class="image-div">
			@if($url->uploaded_path)
				<img style="width:650px; height:380px" src="{{url('/')}}/{{$url->uploaded_path}}" class="img-responsive">
			@else
				<img src="{{url('/')}}/public/images/Git-Icon-1788C.png" class="img-responsive">
			@endif
			</div>
            <br><br><br>

            @if($url->redirecting_text_template)
            <span class="text">{{$url->redirecting_text_template}}</span>
            @else
			<span class="text">Please wait a snap while we take you to the actual website</span>
            @endif
			in <span id="txt_">{{$url->redirecting_time / 1000 }}</span> sec
		</div>
	</div>
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
				            window.location.replace('{{ $url->protocol }}://' + '{{ $url->actual_url }}');
				            HoldOn.close();
				        }, {{ $url->redirecting_time }});
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
