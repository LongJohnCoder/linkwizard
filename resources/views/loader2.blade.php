
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
    
    <title>Tier5 | URL Shortener</title>
    <meta name="description" content="An URL shortener with more sophisticated analytics. Spread your business or creativity using the power of shorten links. Brought to you by Tier5 LLC." />
    <meta name="keywords" content="Tier5 URL Shortener, Tr5.io, Tier5" />
    <meta name="author" content="Tier5 LLC" />
    <meta name="description" content="An URL shortener with more sophisticated analytics. Spread your business or creativity using the power of shorten links. Brought to you by Tier5 LLC." />
    <meta name="keywords" content="Tier5 URL Shortner, Tr5.io, Tier5" />
    <meta name="author" content="Tier5 LLC" />
    <meta property="og:title" content="Tier5 URL Shortener" />
    <meta property="og:url" content="tr5.io" />
    <meta property="og:site_name" content="Tr5.io" />
    <meta property="og:description" content="An URL shortener with more sophisticated analytics. Spread your business or creativity using the power of shorten links. Brought to you by Tier5 LLC." />
    <meta name="twitter:title" content="Tr5.io"  />
    <meta name="twitter:url" content="tr5.io"  />
    <meta name="twitter:card" content="summary"  />
    <meta property="og:url" content="tr5.io" />
    <meta property="al:web:url" content="{{ $url->protocol }}://{{ $url->actual_url }}" />
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

</head>
<body>

	<!-- Main Content Start -->
	<div class="container">
		<div class="centerdiv">
			<div class="image-div">
			@if($url->uploaded_path)
				<img src="{{url('/')}}/{{$url->uploaded_path}}" class="img-responsive">
			@else
				<img src="{{url('/')}}/public/images/Git-Icon-1788C.png" class="img-responsive">
			@endif
			</div>
			
			<span class="text">Please wait a snap while we take you to the actual website</span>
			<span id="txt_"></span>

		</div>
	</div>
	<script type="text/javascript">
    $(document).ready(function() {


		window.setInterval(function(){
		  $('#txt_').text($('#txt_').text() + ' .');
		  $('#txt_').text().length > 10 ? $('#txt_').text('') : null ;
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