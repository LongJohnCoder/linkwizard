<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css">
        <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
        <style type="text/css">
            body {
                /*background: rgb(40, 70, 102) url('/public/resources/img/city-overlay.png') repeat;*/
                font-family: 'Lato';
            }
        </style>
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
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
                    window.location.href = 'http://'+'{{ $url }}';
                    HoldOn.close();
                }, 1000);
            });
        </script>
    </body>
</html>