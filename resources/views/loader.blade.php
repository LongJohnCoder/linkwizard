<?php
$user_agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
} else {
    $referer = parse_url("{{ route('getIndex') }}", PHP_URL_HOST);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css">
        <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
        <style type="text/css">
            body { font-family: 'Lato'; }
        </style>
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: '//freegeoip.net/json/',
                    type: 'POST',
                    dataType: 'jsonp',
                    success: function (location) {
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
            $(document).ready(function () {
                var options = {
                    theme:"custom",
                    content:'<img style="width:80px;" src="{{ URL::to('/').'/public/resources/img/company_logo.png' }}" class="center-block">',
                    message:"Redirecting ...",
                    backgroundColor:"#212230"
                };

                HoldOn.open(options);
                setTimeout(function() {
                    window.location.href = 'http://'+'{{ $url->actual_url }}';
                    HoldOn.close();
                }, 1000);
            });
        </script>
    </body>
</html>
