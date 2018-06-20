<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>

<link href="{{url('/')}}/public/css/bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/public/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('/')}}/public/fonts/font-awesome/css/font-awesome.min.css">

<meta name="description" content="An URL shortener with more sophisticated analytics. Spread your business or creativity using the power of shorten links. Brought to you by Tier5 LLC." />
<meta name="keywords" content="Tier5 URL Shortner, Tr5.io, Tier5" />
<meta name="author" content="Tier5 LLC" />
<link href="{{config('settings.FAVICON')}}" rel="shortcut icon" type="image/ico">
<!-- <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap.min.css" /> -->
<link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
<link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' />
<link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css" />

<link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/custom.css" />
<link rel="stylesheet" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css" />
<link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap-datepicker3.standalone.min.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://www.google.com/jsapi"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.0-rc.2/Chart.bundle.min.js"></script> --}}
<script src="{{ URL::to('/').'/public/resources/js/highcharts.js' }}"></script>
<script src="{{ URL::to('/').'/public/resources/js/highchart-data.js' }}"></script>
<script src="{{ URL::to('/').'/public/resources/js/highchart-drilldown.js' }}"></script>
<script src="{{ URL::to('/').'/public/resources/js/modernizr.custom.js' }}"></script>

<!-- Choseen jquery  -->
<link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/prism.css' }}">
<link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/chosen.css' }}">
<script src="{{ URL::to('/').'/public/resources/js/chosen/chosen.jquery.js' }}" type="text/javascript"></script>
<script src="{{ URL::to('/').'/public/resources/js/chosen/prism.js' }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ URL::to('/').'/public/resources/js/chosen/init.js' }}" type="text/javascript" charset="utf-8"></script>
<!-- Choseen jquery  -->

{{-- Tags css --}}
<link rel="stylesheet" href="{{ URL('/')}}/public/css/bootstrap-tagsinput.css" />

{{-- Tags js --}}
<script src="{{URL::to('/').'/public/js/bootstrap-tagsinput.js'}}"></script>

@if(\Session::has('plan'))
<script type="text/javascript">
	$(document).ready(function(){
		var plan = "{{\Session::get('plan')}}";
		var url = "{{url('/')}}/app/user/subscribe";
		window.location.replace(url);
	});
</script>
@endif




<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- <script src="{{url('/')}}/public/js/bootstrap.min.js"></script> -->





<meta property="og:title" content="Tier5 URL Shortener" />
<meta property="og:image" content="{{ URL('/')}}/public/resources/img/company_logo.png" />
<meta property="og:url" content="tr5.io" />
<meta property="og:site_name" content="Tr5.io" />
<meta property="og:description" content="An URL shortener with more sophisticated analytics. Spread your business or creativity using the power of shorten links. Brought to you by Tier5 LLC." />
<meta name="twitter:title" content="Tr5.io"  />
<meta name="twitter:image" content="{{ URL('/')}}/public/resources/img/company_logo.png"  />
<meta name="twitter:url" content="tr5.io"  />
<meta name="twitter:card" content="summary"  />


<script src="//connect.facebook.net/en_US/sdk/debug.js"></script>
<script src="{{ URL::to('/').'/public/js/fb_share.js'}}"></script>

<!-- /Facebook API -->
<!-- Google API -->
<script>
    window.___gcfg = {
        lang: 'en-US',
        parsetags: 'onload'
    };
</script>
<script src="https://apis.google.com/js/client:platform.js" async defer></script>
<!-- /Google API -->
<!-- Twitter API -->
<script>
    window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
        t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);

        t._e = [];
        t.ready = function(f) {
            t._e.push(f);
        };

        return t;
    }(document, "script", "twitter-wjs"));
</script>
<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>
<!-- /Twitter API -->
<!-- LinkedIn API -->
<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
<!-- /LinkedIn API -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" />

</head>
