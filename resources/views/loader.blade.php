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
    <meta charset="utf-8" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="viewport" content="width=device-width,maximum-scale=1,user-scalable=no,minimal-ui">
    <title>Tier5 | URL Shortener | 301 Redirecting...</title>
    <meta name="description" content="A free URL shortner brought to you by Tier5 LLC." />
    <meta name="keywords" content="Tier5 URL Shortner, Tr5.io, Tier5" />
    <meta name="author" content="Tier5 LLC" />
    <link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css" />
    <link rel="stylesheet" type="text/css" href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' />
    <style type="text/css">
    body {
        font-family: 'Nunito';
    }

    </style>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
    <script>
    $(document).ready(function() {
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
                    }
                });
            }
        });
    });

    </script>
    <script>
    $(document).ready(function() {
        @if ($url->uploaded_path == null)
            var uploadedPath = "{{ URL::to('/').'/public/resources/img/tier5_animation.gif' }}";
        @else
            var uploadedPath = "{{ $url->uploaded_path }}";
        @endif
        var options = {
            theme: "custom",
            content: '<div><img style="margin: auto;" src='+uploadedPath+' class="center-block" /></div><br />',
            message: "{{ $url->redirecting_text_template }}",
            backgroundColor: "#212230"
        };

        HoldOn.open(options);
        setTimeout(function() {
            window.location.href = 'http://' + '{{ $url->actual_url }}';
            HoldOn.close();
        }, {{ $url->redirecting_time }});
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

