<!DOCTYPE html>
<html lang="en">
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
<link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap.min.css" />
<link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
<link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' />
<link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css" />
<link rel="stylesheet" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css" />
<link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/custom.css" />
<link rel="stylesheet" href="https://sdkcarlos.github.io/sites/holdon-resources/css/HoldOn.css" />
<link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap-datepicker3.standalone.min.css" />
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script> 
<script src="https://www.google.com/jsapi"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.0-rc.2/Chart.bundle.min.js"></script> --}}
<script src="{{ URL::to('/').'/public/resources/js/highcharts.js' }}"></script>
<script src="{{ URL::to('/').'/public/resources/js/highchart-data.js' }}"></script>
<script src="{{ URL::to('/').'/public/resources/js/highchart-drilldown.js' }}"></script>
<script src="{{ URL::to('/').'/public/resources/js/modernizr.custom.js' }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script src="http://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

<script src="{{url('/')}}/public/js/bootstrap.min.js"></script>




<meta property="og:title" content="Tier5 URL Shortener" />
<meta property="og:image" content="{{ URL('/')}}/public/resources/img/company_logo.png" />
<meta property="og:url" content="tr5.io" />
<meta property="og:site_name" content="Tr5.io" />
<meta property="og:description" content="An URL shortener with more sophisticated analytics. Spread your business or creativity using the power of shorten links. Brought to you by Tier5 LLC." />
<meta name="twitter:title" content="Tr5.io"  />
<meta name="twitter:image" content="{{ URL('/')}}/public/resources/img/company_logo.png"  />
<meta name="twitter:url" content="tr5.io"  />
<meta name="twitter:card" content="summary"  />


<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId   : '1637007456611127',
            xfbml   : true,
            version : 'v2.7'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
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

</head>
<body>
<!-- Header Start -->

<header>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<div class="logo">
					<img src="{{url('/')}}/public/images/logo.png" class="img-responsive">
				</div>
			</div>

			<div class="col-md-6">
				<div class="top-right">
					@if(count($limit) > 0)
					<div class="createlink">
						<a href="javascript:void(0)" id="basic" ">Create tier5 link</a>
					</div>
					@endif
					@if ($subscription_status != null)
						 @if(count($limit) > 0)
						 	<div class="createlink">
						 		<a href="javascript:void(0)" id="advanced" style="background-color:red">Create Custom link</a>
						 	</div>
						 @endif
					@endif
					@if ($user->is_admin == 1)
                        <div class="menu-icon">
                            <a href="{{ route('getAdminDashboard') }}">
                                <button id="" class="btn btn-warning">
                                    ADMIN DASHBOARD
                                </button>
                            </a>
                        </div>
                    @endif
					<div class="hamburg-menu">
	                  <a href="#" id="menu-icon" class="menu-icon" style="display: block;">
	                    <div class="span bar top" style="background-color: #fff;"></div>
	                    <div class="span bar middle" style="background-color: #fff;"></div>
	                    <div class="span bar bottom" style="background-color: #fff;"></div>
	                  </a>
	                </div>
	                <div id="userdetails" class="userdetails">
	                	<div>
		                	<a href="{{ route('getLogout') }}" class="signout"><i class="fa fa-sign-out"></i> Sign out</a>
		                	<p style="color:white">{{ $user->name }}</p>
		                	<p style="color:white">{{ $user->email }}</p>
		                	@if ($subscription_status != 'tr5Advanced')
		                		<a href="{{ route('getSubscribe') }}" class="upgrade"><i class="fa fa-sign-out"></i> Upgrade</a>
		                	@endif
	                	</div>
	                </div>

	                <div id="myNav1" class="userdetails">
	                	<a href="#" id="cross1" class="closebtn"><i class="fa fa-times" style="color:white"></i></a>
		                <div class="overlay-content">
		                    <div class="row">
		                        <div class="col-md-12 col-sm-12">
		                            <label for="givenUrl" style="color:white">Paste An Actual URL Here</label>
		                            <input id="givenUrl" class="myInput form-control" type="text" name="" placeholder="Paste Your URL Here">
		                            <button id="swalbtn" type="submit" class="btn btn-primary btn-sm">
		                                Shorten Url
		                            </button>
		                        </div>
		                    </div>
		                </div>
	                </div>

	                <div id="myNav2" class="userdetails">
		                <a href="#" id="cross2" class="closebtn"><i class="fa fa-times" style="color:white"></i></a>
		                <div class="overlay-content">
		                    <div class="row">
		                        <div class="col-md-12 col-sm-12">
		                            <label for="givenActualUrl" style="color:white;">Paste An Actual URL Here</label>
		                            <input id="givenActualUrl" style="width:280px" class="myInput form-control" type="text" name="" placeholder="Paste Your URL Here">
		                            <br>
		                            <br>
		                            <label for="makeCustomUrl" style="color:white">Create Your Own Custom Link</label>
		                            <div class="input-group">
		                                <span class="input-group-addon">{{ env('APP_HOST') }}/</span>
		                                <input id="makeCustomUrl" class="myInput form-control" type="text" name="" placeholder="e.g. MyLinK">
		                            </div>
		                            <button id="swalbtn1" type="submit" class="btn btn-primary btn-sm">
		                                Shorten Url
		                            </button>
		                        </div>
		                    </div>
		                </div>
		            </div>

				</div>
			</div>
		</div>
	</div>
</header>
<!-- Header End -->
<!-- Banner Start -->
<div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Select date range</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('getDashboard') }}" method="get" role="form" class="form" id="datePickerForm">
                    <div class="form-group">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="from" id="datePickerFrom" required />
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="to" id="datePickerTo" required />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Apply</button>
                    <br />
                </form>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </center>
            </div>
        </div>
    </div>
</div>
<section class="banner">
	<div class="container">
		<div class="row">
			<div class="banner-top">
				<div class="col-md-6">
					<div class="tot-counts">
						<img src="{{url('/')}}/public/images/barcount.jpg" class="img-responsive">
						<div class="count"><span>{{$count_url}}</span>total counts</div> <!-- ?count -->
					</div>
				</div>
				<div class="col-md-6">
					<div class="datelink dateRangeButton" data-toggle="modal" data-target="#datePickerModal">
						<a href="#">{{ date('M d', strtotime('-1 month')) .' - '. date('M d') }}</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="columnChart" style="min-width: 310px; height: 165px; margin: 0 auto"></div> <!-- col-md-12 graph -->
			</div>
		</div>
	</div>
</section>
<!-- Banner End -->
<!-- Main Content Start -->
<section class="main-content tabsection">
	<div class="container">
		<div class="row">
	        <div class="col-md-12">
	            <div class="col-md-4 col-sm-4">
		            <div class="list-group">
		              	@if($count_url > 1)
		              	<h2 id="cnt_link">{{$count_url}} links</h2>
		              	@else
		              	<h2 id="cnt_link">{{$count_url}} link</h2>
		              	@endif
		              	<ul>
		              		@foreach ($urls as $key => $url)
			                <li class="active">
			                
			                	<div class="check">
			                 		<input type="checkbox" name="">
			                 	</div>
			                 	<div class="tab-cont">
				                 	<div class="date">{{ date('M d, Y', strtotime($url->created_at)) }}</div>
				                 	<p>{{ $url->title }}</p>
				                 	@if (isset($url->subdomain))
						                @if($url->subdomain->type == 'subdomain')
						                    <a class="link" href=http://{{ $url->subdomain->name }}.{{ env('APP_HOST') }}/{{ $url->shorten_suffix }}>http://{{ $url->subdomain->name }}.{{ env('APP_HOST') }}/{{ $url->shorten_suffix }}</a>

						                @elseif($url->subdomain->type == 'subdirectory')
												<a class="link" href="{{ route('getIndex') }}/{{ $url->subdomain->name }}/{{ $url->shorten_suffix }}">{{ route('getIndex') }}/{{ $url->subdomain->name }}/{{ $url->shorten_suffix }}</a>
						                @endif
						            @else
						                <a class="link" href="{{ route('getIndex') }}/{{ $url->shorten_suffix }}">{{ route('getIndex') }}/{{ $url->shorten_suffix }}</a>
						            @endif
				                 	<div class="flags">
				                 		{{$url->count}}<img src="{{url('/')}}/public/images/bar2.png" class="img-responsive">
				                 	</div>
			                 	</div>
			                
			                </li>
			                @endforeach
		                </ul>
		            </div>
	            </div>


	            <div class="col-md-8 col-sm-8">
	                <!-- flight section -->
	                @foreach ($urls as $key => $url)
	                <div class="tab-content">
	                	<div class="tab-content-top">
		                	<div class="date">{{ date('M d, Y', strtotime($url->created_at)) }}</div>
		                	<p id="urlTitleHeading{{ $key }}">{{$url->title}}</p>
		                	<a href="{{ $url->protocol }}://{{ $url->actual_url }}">{{ $url->protocol }}://{{ $url->actual_url }}</a>
	                	</div>
	                	<div class="row">
	                		 <div class="col-md-6 col-sm-6">
	                		 	@if (isset($url->subdomain))
                                    <h3>
                                        @if($url->subdomain->type == 'subdomain')
  											<a href="http://{{ $url->subdomain->name }}.{{ env('APP_HOST') }}/{{ $url->shorten_suffix }}" target="_blank" class="link" id="copylink{{ $key }}">
                                                http://{{ $url->subdomain->name }}.{{ env('APP_HOST') }}/{{ $url->shorten_suffix }}
                                            </a>
                                        @elseif($url->subdomain->type == 'subdirectory')
                                            <a href="{{ route('getIndex') }}/{{ $url->subdomain->name }}/{{ $url->shorten_suffix }}" target="_blank" class="link" id="copylink{{ $key }}">
                                                {{ route('getIndex') }}/{{ $url->subdomain->name }}/{{ $url->shorten_suffix }}
                                            </a>
                                        @endif
                                    </h3>
                                @else
                                    <h3>
                                        <a href="{{route('getIndex') }}/{{ $url->shorten_suffix }}" target="_blank" class="link" id="copylink{{ $key }}">
                                            {{ route('getIndex') }}/{{ $url->shorten_suffix }}
                                        </a>
                                    </h3>
                                @endif
	                		 </div>


	                		 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="buttons">
                                        <button id="clipboard{{ $key }}" class="btn btn-default btn-sm btngrpthree" data-clipboard-action="copy"  data-clipboard-target="#copylink{{ $key }}" style="width:70px">
                                            <i class='fa fa-clipboard'></i> copy
                                        </button>
                                        <button id="edit-btn{{ $key }}" class="btn btn-default btn-sm btngrpthree" style="width:70px">
                                            <i class='fa fa-pencil'></i> edit
                                        </button>
                                        <button id="fb-share-btn{{ $key }}" class="btn btn-default btn-sm btngrpthree" style="width:70px">
                                            <i class='fa fa-facebook'></i> share
                                        </button>
                                        <button id="gp-share-btn{{ $key }}" class="btn btn-default btn-sm btngrpthree g-interactivepost" data-clientid="1094910841675-1rtgjkoe9l9p5thbgus0s1vlf9j5rrjf.apps.googleusercontent.com" data-contenturl="{{ route('getIndex') }}/{{ $url->shorten_suffix }}" data-cookiepolicy="none" data-prefilltext="{{ $url->title }}" data-calltoactionlabel="SEND" data-calltoactionurl="{{ route('getIndex') }}/{{ $url->shorten_suffix }}" style="width:70px">
                                            <i class='fa fa-google-plus'></i> share
                                        </button>
                                        <a href="https://twitter.com/intent/tweet?text={{ $url->title }} please visit {{ route('getIndex') }}/{{ $url->shorten_suffix }} to know more." style="border: none; padding: 0px; margin: 0px;">
                                            <button id="tw-share-btn{{ $key }}" class="btn btn-default btn-sm btngrpthree" style="width:70px">
                                                <i class='fa fa-twitter'></i> share
                                            </button>
                                        </a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('getIndex') }}/{{ $url->shorten_suffix }}&title={{ $url->title }}&summary={{ $url->title }}&source=LinkedIn" target="_blank" onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no'); return false;" style="border: none; padding: 0px; margin: 0px;">
                                            <button id="tw-share-btn{{ $key }}" class="btn btn-default btn-sm btngrpthree" style="width:70px">
                                                <i class='fa fa-linkedin'></i> share
                                            </button>
                                        </a>
                                        @if ($subscription_status != null)
                                            <button id="addBrand{{ $key }}" class="btn btn-default btn-sm btngrpthree" style="width:130px">
                                                <i class="fa fa-bullhorn"></i> create brand
                                            </button>
                                            @if (!isset($url->subdomain))
                                                <button id="brandLink{{ $key }}" class="btn btn-default btn-sm btngrpthree" style="width:130px">
                                                    <i class="fa fa-anchor"></i> Brand Link
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                    <script>
                                        $(document).ready(function () {

                                        	function initSummernote(preloadText) {
							                $('#redirectingTextTemplate').summernote({
							                    height: 100,
							                    minHeight: null,
							                    maxHeight: null,
							                    focus: true,
							                    toolbar: [
							                        ['style', ['bold', 'italic', 'underline']],
							                        ['fontsize', ['fontsize']],
							                        ['color', ['color']],
							                        ['height', ['height']],
							                        ['insert', ['link']],
							                        ['misc', ['undo', 'redo', 'codeview']]
							                    ]
							                });
							                $('#redirectingTextTemplate').summernote('code', preloadText);
            }
                                        	
                                            $('#clipboard{{ $key }}').on('click', function () {
                                                new Clipboard('#clipboard{{ $key }}');
                                            });
                                            $('#edit-btn{{ $key }}').on('click', function () {
                                                $("#editModalBody #urlTitle").val('{{ $url->title }}');
                                                $("#editModalBody #urlId").val('{{ $url->id }}');
                                                $('#myModal').modal('show');
                                                editAction({{ $key }});
                                            });
                                            $('#fb-share-btn{{ $key }}').on('click', function () {
                                                FB.ui({
                                                    method: 'share',
                                                    href: '{{ route('getIndex') }}/{{ $url->shorten_suffix }}',
                                                    caption: '{{ $url->title }}',
                                                    display: 'popup',
                                                    source: 'http://urlshortner.dev/public/resources/img/company_logo.png'
                                                }, function(response){});
                                            });
                                            $('#addBrand{{ $key }}').on('click', function () {
	                                            $("#urlId").val('{{ $url->id }}');
	                                            $("#redirectingTime").val('{{ $url->redirecting_time/1000 }}');
	                                            initSummernote('{!! $url->  redirecting_text_template !!}');
	                                            $('#myModal1').modal('show');
	                                        });
                                            $('#brandLink{{ $key }}').on('click', function () {
                                                $("#subdomainModalBody #urlId").val('{{ $url->id }}');
                                                $('#subdomainModal').modal('show');
                                            });
                                        });
                                    </script>
                                </div>
	                		 
	                	</div>
	                	<div class="row">
	                		 <div class="col-md-6 col-sm-6">
	                		 	<a href="#" class="tot-count"><img src="{{url('/')}}/public/images/bar2.png" class="img-responsive">{{ $url->count }} total counts</a>
	                		 </div>
	                		 <div class="col-md-6 col-sm-6"></div>
	                	</div>
	                	<div class="row">
	                		<div class="col-md-12 col-sm-12">
	                		 	<div class="tot-clicks">
		                		 	<h2>Number of hits per country</h2>
		                		 	<div class="tot-clicks-body">
		                		 		<div id="regions_div{{ $key }}" style="width: 450px; height: 250px;"></div>
		                		 	</div>
	                		 	</div>
	                		</div>
	                		<div class="col-md-6 col-sm-4">
	                		 	<div class="tot-clicks">
	                		 		<h2>Total Clicks 2 (100%)</h2>
	                		 		<div class="tot-clicks-body">
	                		 			<div id="chart_div{{ $key }}" style="width: 350px; height: 250px;"></div>
	                		 		</div>
	                		 	</div>
	                		</div>
	                		@if ($subscription_status != null)

	                			<div class="col-md-6 col-sm-6">
		                		 	<div class="tot-clicks">
		                		 		<h2>Platform Status</h2>
		                		 		<div class="tot-clicks-body">
		                		 			<div id="platform_div{{ $key }}" style="width: 400px; height: 250px;"></div>
		                		 		</div>
		                		 	</div>
		                		</div>


		                		<div class="col-md-6 col-sm-6">
		                		 	<div class="tot-clicks">
		                		 		<h2>Browser Status</h2>
		                		 		<div class="tot-clicks-body">
		                		 			<div id="browser_div{{ $key }}" style="width: 400px; height: 250px;"></div>
		                		 		</div>
		                		 	</div>
		                		</div>

		                		<div class="col-md-6 col-sm-6">
		                		 	<div class="tot-clicks">
		                		 		<h2>Referring Chanels</h2>
		                		 		<div class="tot-clicks-body">
		                		 			<div id="referral_div{{ $key }}" style="width: 400px; height: 250px;"></div>
		                		 		</div>
		                		 	</div>
		                		</div>
                        	@endif

                        	<!-- charts and graphs script here -->
                        	<script type="text/javascript">
                                    {!! $key == 0 ? "google.charts.load('current', {'packages':['corechart', 'geochart']});" : null !!}
                                    $.ajax({
                                        url: "{{ route('postFetchAnalytics') }}",
                                        type: 'POST',
                                        data: {url_id: {{ $url->id }}, _token: "{{ csrf_token() }}"},
                                        success: function (response) {
                                            if (response.status == "success") {
                                                google.charts.setOnLoadCallback(function () {
                                                    var data = google.visualization.arrayToDataTable(response.location);
                                                    var options = {
                                                        colorAxis: {colors: '#3366ff'},
                                                        background: 'rgba(255, 255, 255, 0.8)',
                                                        width: 650,
                                                        height: 250,
                                                    };
                                                    var chart{{ $key }} = new google.visualization.GeoChart(document.getElementById('regions_div{{ $key }}'));
                                                    chart{{ $key }}.draw(data, options);
                                                    @if ($subscription_status != null)
                                                    google.visualization.events.addListener(chart{{ $key }}, 'select', function() {
                                                        var selectionIdx = chart{{ $key }}.getSelection()[0].row;
                                                        var countryName = data.getValue(selectionIdx, 0);
                                                        window.location.href = '{{ route('getIndex') }}/{{ $url->shorten_suffix }}/country/' + countryName + '/analytics';
                                                    });
                                                    @endif
                                                });
                                                google.charts.setOnLoadCallback(function () {
                                                    var data = google.visualization.arrayToDataTable(response.location);
                                                    var options = {
                                                        title: 'Number of hits per country',
                                                        width: 350,
                                                        height: 250,
                                                    };
                                                    var chart{{ $key }} = new google.visualization.PieChart(document.getElementById('chart_div{{ $key }}'));
                                                    chart{{ $key }}.draw(data, options);
                                                    @if ($subscription_status != null)
                                                    google.visualization.events.addListener(chart{{ $key }}, 'select', function() {
                                                        var selectionIdx = chart{{ $key }}.getSelection()[0].row;
                                                        var countryName = data.getValue(selectionIdx, 0);
                                                        window.location.href = '{{ route('getIndex') }}/{{ $url->shorten_suffix }}/country/' + countryName + '/analytics';
                                                    });
                                                    @endif
                                                });
                                                @if ($subscription_status != null)
                                                google.charts.setOnLoadCallback(function () {
                                                    var data = google.visualization.arrayToDataTable(response.platform);
                                                    var options = {
                                                        title: 'Platform Shares',
                                                        pieHole: 0.4,
                                                        slices: {textStyle: {fontSize: 6}},
                                                        width: 400,
                                                        height: 250,
                                                    };
                                                    var chart{{ $key }} = new google.visualization.PieChart(document.getElementById('platform_div{{ $key }}'));
                                                    chart{{ $key }}.draw(data, options);
                                                });
                                                google.charts.setOnLoadCallback(function () {
                                                    var data = google.visualization.arrayToDataTable(response.browser);
                                                    var options = {
                                                        title: 'Browser Stats',
                                                        pieHole: 0.4,
                                                        slices: {textStyle: {fontSize: 6}},
                                                        width: 400,
                                                        height: 250,
                                                    };
                                                    var chart{{ $key }} = new google.visualization.PieChart(document.getElementById('browser_div{{ $key }}'));
                                                    chart{{ $key }}.draw(data, options);
                                                });
                                                google.charts.setOnLoadCallback(function () {
                                                    var data = google.visualization.arrayToDataTable(response.referer);
                                                    var options = {
                                                        title: 'Referring Channels',
                                                        pieHole: 0.4,
                                                        slices: {textStyle: {fontSize: 6}},
                                                        width: 400,
                                                        height: 250,
                                                    };
                                                    var chart{{ $key }} = new google.visualization.PieChart(document.getElementById('referral_div{{ $key }}'));
                                                    chart{{ $key }}.draw(data, options);
                                                });
                                                @endif
                                            } else {
                                             console.log('Response error!');
                                            }
                                        }
                                    });
                            </script>
	                	</div>
	                </div>
	                @endforeach
	                <!-- hotel search --> 
	            </div>
	        </div>
		</div>
	</div>


	 @if (count($urls) > 0)
        <div class="modal fade bs-modal-sm in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body" id="editModalBody">
                        <form class="form-inline" method="post">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="urlTitle">Title</label>
                                    <input type="text" name="title" placeholder="Your URL Title" class="form-control input-mg" id="urlTitle" style="width: 80%" value="" />
                                    <button type="button" class="btn btn-warning" id="editUrlTitle">
                                        Edit
                                    </button>
                                    <input type="hidden" name="id" id="urlId" value="" />
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
                                Close
                            </button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-modal-lg in" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="subdomainModalLabel">
                            Manage Redirecting Page Template For Your Custom Url
                        </h4>
                    </div>
                    <div class="modal-body" id="uploadModalBody">
                        <form class="form" role="form" action="{{ route('postBrandLogo') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="url_id" value="{{ $url->id }}" id="urlId" />
                            <div class="form-group">
                                <label for="brandLogo">Upload brand logo</label>
                                <input type="file" id="brandLogo1" name="brandLogo" class="form-control input-md" style="padding: 0px 0px 34px 0px;" value="" />
                            </div>
                            <div class="form-group">
                                <label for="redirectingTime">Set redirecting time (in seconds)</label>
                                <input type="number" min="0" max="60" id="redirectingTime" name="redirectingTime" class="form-control input-md" value="" />
                            </div>
                            <div class="form-group">
                                <label for="redirectingTextTemplate">Set redirecting text template</label>
                                <textarea id="redirectingTextTemplate" name="redirectingTextTemplate" class="form-control input-md"></textarea>
                            </div>
                            <hr />
                            <button type="submit" class="btn btn-default btn-md pull-right">
                                Submit
                            </button>
                        </form>
                        <br />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-modal-md" id="subdomainModal" tabindex="-1" role="dialog" aria-labelledby="subdomainModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="subdomainModalLabel">
                            Create Your Own Brand Link
                        </h4>
                    </div>
                    <div class="modal-body" id="subdomainModalBody">
                        <p>
                            You may want to customize url like following:
                        </p>
                        <ul class="list-unstyled">
                            <li>yourbrand.tr5.io/abcdef (as a subdomain)</li>
                            <li>tr5.io/yourbrand/abcdef (as a subdirectory)</li>
                        </ul>
                        <p id="subdomainWarning" style="color: red; display: none;">
                            <strong>Warning:</strong> Brand name can not be changed later. This action will not be undone!
                        </p>
                        <form class="form" role="form" action="{{ route('postBrandLink') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="url_id" value="{{ $url->id }}" id="urlId" />
                            <div class="form-group">
                                <label for="subdomainBrand"></label>
                                <input type="text" name="name" id="subdomainBrand" class="form-control" placeholder="Enter your brand name here" />
                            </div>
                            <div class="form-group">
                                <label for="">I want a</label>
                                <input type="radio" id="" name="type" value="subdomain" /> Subdomain
                                <input type="radio" id="" name="type" value="subdirectory" /> Subdirectory
                            </div>
                            <hr />
                            <button type="submit" class="btn btn-default btn-md pull-right">Submit</button>
                        </form>
                        <br />
                        <script>
                            $(document).ready(function () {
                                $('#subdomainBrand').on('blur', function () {
                                    nameRegex = new RegExp('^([a-z]){2,}$');
                                    nameInput = $(this).val();
                                    if (nameInput == null) {
                                        $(this).focus();
                                        $(this).parent().append("<span id='subdomainAlert' style='color: red'>Subdomain should not be blank.</span>");
                                        return false;
                                    } else if (!nameRegex.test(nameInput)) {
                                        $(this).focus();
                                        $(this).parent().append("<span id='subdomainAlert' style='color: red'>Subdomain should be in lowercase.</span>");
                                        return false;
                                    } else {
                                        return true;
                                    }
                                });
                                $('#subdomainBrand').on('focus', function () {
                                    $('#subdomainAlert').remove('#subAlert');
                                    $('#subdomainWarning').css('display', 'block');
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Select date range</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('getDashboard') }}" method="get" role="form" class="form" id="datePickerForm">
                            <div class="form-group">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="from" id="datePickerFrom" required />
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" name="to" id="datePickerTo" required />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Apply</button>
                            <br />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        @endif

         <script>
            function editAction(key) {
                $('#editUrlTitle').on('click', function () {
                    var id = $('.modal-body #urlId').val();
                    var title = $('.modal-body #urlTitle').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('postEditUrlInfo') }}',
                        data: {id: id, title: title, _token: "{{ csrf_token() }}"},
                        success: function(response) {
                            $('#myModal').modal('hide');
                            swal({
                                title: "Success",
                                text: "Successfully edited title",
                                type: "success",
                                html: true
                            });
                            $('#urlTitleHeading'+key).replaceWith('<h1 id="urlTitleHeading"'+key+'>'+response.url.title+'</div>');
                            $('#tab-title'+key).replaceWith('<span id="tab-title"'+key+' class="title">'+response.url.title+'</span>');
                            $(".modal-body #urlTitle").val(response.url.title);
                        },
                        error: function(response) {
                            swal({
                                title: "Oops!",
                                text: "Cannot edit this title",
                                type: "warning",
                                html: true
                            });
                        }
                    });
                });
            }
        </script>


</section>



<div class="clear"></div>

<script type="text/javascript">

	$(document).ready(function() {


		$("#menu-icon").click(function(){
	    	$(this).toggleClass("close");
	    	$('#myNav1').hide(100);
	    	$('#userdetails').slideToggle(500);
	    });

	    $("#basic").click(function(){
	    	$('#menu-icon').slideToggle(500);
	    	$('#userdetails').hide(500);
	    	$('#myNav1').slideToggle(500);
	    });

	    $("#cross1").click(function(){
	    	$('#userdetails').hide();
	    	$('#myNav1').hide(500);
	    	$('#myNav2').hide(500);
	    	
	    	$('#menu-icon').slideToggle(500);
	    });

	    $("#advanced").click(function(){
	    	
	    	$('#menu-icon').slideToggle(500);
	    	$('#userdetails').hide(500);
	    	$('#myNav1').hide(500);
	    	$('#myNav2').slideToggle(500);
	    });

	    $("#cross2").click(function(){
	    	$('#userdetails').hide();
	    	$('#myNav1').hide(500);
	    	$('#myNav2').hide(500)
	    	
	    	$('#menu-icon').slideToggle(500);
	    });



		
		$('[data-toggle="tooltip"]').tooltip();
        $('#hamburger').on('click', function () {
            $('.sidebar.right').addClass('open', true);
            $('.sidebar.right').removeClass('close', true);
        });
        $('#cross').on('click', function () {
            $('.sidebar.right').toggleClass('close', true);
            $('.sidebar.right').removeClass('open', true);
        });
        $('#tr5link').on('click', function () {
            $('.tr5link').addClass('open', true);
            $('.tr5link').removeClass('close', true);
        });
        
        $('#customLink').on('click', function () {
            $('.sharebar').addClass('open', true);
            $('.sharebar').removeClass('close', true);
        });
        $('#cross2').on('click', function () {
            $('.sharebar').addClass('close', true);
            $('.sharebar').removeClass('open', true);
        });
        $('#noTr5Link').on('click', function () {
            swal({
                type: 'warning',
                title: 'Notification',
                text: 'You have maximum shorten links. Please upgrade account to get hassle free services.'
            });
        });
        $('#noCustomLink').on('click', function () {
            swal({
                type: 'warning',
                title: 'Notification',
                text: 'You have maximum shorten links. Please upgrade account to get hassle free services.'
            });
        });

	    
	});
</script>
<script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
<script src="{{ URL::to('/').'/public/resources/js/min/toucheffects-min.js'}}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".list-group ul li").click(function(){
			$(this).addClass("active");
			$(".list-group ul li").not($(this)).removeClass("active");

			var index = $(this).index();
		        $("div.tab-content").removeClass("active");
		        $("div.tab-content").eq(index).addClass("active");
			});
	});
</script>


<script>
            $(document).ready(function () {
                var options = {
                    theme:"custom",
                    content:'<img style="width:80px;" src="{{ URL::to('/').'/public/resources/img/company_logo.png' }}" class="center-block">',
                    message:"Please wait a while",
                    backgroundColor:"#212230"
                };
	        $('#swalbtn1').click(function(){

                	var actualUrl = $('#givenActualUrl').val();
                    var customUrl = $('#makeCustomUrl').val();
                    @if (Auth::user())
                        var userId = {{ Auth::user()->id }};
                    @else
                        var userId = 0;
                    @endif
                    if (ValidURL(actualUrl)) 
                    {
                        if (ValidCustomURL(customUrl)) 
                        {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('postCustomUrlTier5') }}",
                                data: {
                                    actual_url: actualUrl,
                                    custom_url: customUrl,
                                    user_id: userId,
                                    _token: "{{ csrf_token() }}"
                                }, success: function (response) {
                                    if(response.status=="success") {
                                        var shortenUrl = response.url;
                                        var displayHtml = "<a href="+shortenUrl+" target='_blank' id='newshortlink'>"+shortenUrl+"</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink''><i class='fa fa-clipboard'></i> Copy</button>";
                                        swal({
                                            title: "Shorten Url:",
                                            text: displayHtml,
                                            type: "success",
                                            html: true
                                        }, function() {
                                            window.location.reload();
                                        });
                                        new Clipboard('#clipboardswal');
                                        $('#clipboardswal').on('click', function () {
                                            window.location.reload();
                                        });
                                        HoldOn.close();
                                    } else {
                                        swal({
                                            title: null,
                                            text: "Please paste an actual URL",
                                            type: "warning",
                                            html: true
                                        }); 
                                        HoldOn.close();
                                    }
                                }, error: function(response) {
                                    console.log('Response error!');
                                    HoldOn.close();
                                }, statusCode: {
                                    500: function() {
                                        swal({
                                            title: null,
                                            text: "Access Forbidden, Please paste a valid URL!",
                                            type: "error",
                                            html: true
                                        }); 
                                        HoldOn.close();
                                    }
                                }
                            });
                        } 
                        else 
                        {
                            swal({
                                type: "warning",
                                title: null,
                                text: "Please Enter A Custom URL<br>It Should Be AlphaNumeric",
                                html: true
                            });
                        }
                    } 
                    else 
                    {
                        swal({
                            type: "warning",
                            title: null,
                            text: "Please Enter An URL"
                        	});     
                    }

                }); 
                

                
                function ValidURL(str) {
                    var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|ac|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
                    var url = str;
                    if (!regexp.test(url)) {
                        return false;
                    } else {
                        return true;
                    }
                }

                function ValidCustomURL(str) {
                    var regexp = new RegExp("^[a-zA-Z0-9_]+$");
                    var url = str;
                    if (!regexp.test(url)) {
                        return false;
                    } else {
                        return true;
                    }
                }

                $('#swalbtn').click(function() {
                    var url = $('#givenUrl').val();
                    var validUrl = ValidURL(url);
                    @if (Auth::user())
                        var userId = {{ Auth::user()->id }};
                    @else
                        var userId = 0;
                    @endif
                    if(url) {
                        if(validUrl) {
                            HoldOn.open(options);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('postShortUrlTier5') }}",
                                data: {url: url, user_id: userId, _token: "{{ csrf_token() }}"},
                                success: function (response) {
                                    if(response.status=="success") {
                                        var shortenUrl = response.url;
                                        var displayHtml = "<a href="+shortenUrl+" target='_blank' id='newshortlink'>"+shortenUrl+"</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink''><i class='fa fa-clipboard'></i> Copy</button>";
                                        swal({
                                            title: "Shorten Url:",
                                            text: displayHtml,
                                            type: "success",
                                            html: true
                                        }, function() {
                                            window.location.reload();
                                        });
                                        new Clipboard('#clipboardswal');
                                        $('#clipboardswal').on('click', function () {
                                            window.location.reload();
                                        });
                                        HoldOn.close();
                                    } else {
                                        swal({
                                            title: null,
                                            text: "Please paste an actual URL",
                                            type: "warning",
                                            html: true
                                        }); 
                                        HoldOn.close();
                                    }
                                }, error: function(response) {
                                    console.log('Response error!');
                                    HoldOn.close();
                                }, statusCode: {
                                    500: function() {
                                        swal({
                                            title: null,
                                            text: "Access Forbidden, Please paste a valid URL!",
                                            type: "error",
                                            html: true
                                        }); 
                                        HoldOn.close();
                                    }
                                }
                            });
                        } else {
                            var errorMsg="Enter A Valid URL";
                            swal({
                                title: null,
                                text: errorMsg,
                                type: "error",
                                html: true
                            }); 
                        }
                    } else {
                        var errorMsg="Please Enter An URL";
                        swal({
                            title: null,
                            text: errorMsg,
                            type: "warning",
                            html: true
                        });     
                    }
                });

            });
            
        </script>
        <script type="text/javascript">
        $(document).ready(function () {
            $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
        });
        </script>
        <script>
            @if (isset($filter) and $filter != null) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('postChartDataFilterDateRange') }}",
                    data: {
                        "user_id": {{ $user->id }},
                        "start_date": "{{ $filter['start'] }}",
                        "end_date": "{{ $filter['end'] }}",
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        var chartDataStack = [];
                        $('#columnChart').highcharts({
                            chart: {
                                type: 'column',
                                backgroundColor: 'rgba(255, 255, 255, 0)'
                            },
                            title: {
                                text: null
                            },
                            xAxis: {
                                type: 'category',
                                labels: {
                                    style: {
                                        fontWeight: 'bold',
                                        color: '#fff'
                                    }
                                }
                            },
                            yAxis: {
                                labels: {
                                    enabled: false
                                },
                                title: {
                                    text: null
                                },
                                gridLineWidth: 0,
                                minorGridLineWidth: 0
                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: false,
                                        format: '{point.y:.1f}%'
                                    },
                                    events:{
                                        click: function (event) {
                                            var pointName = event.point.name;
                                            if (pointName.search('{{ url('/') }}')) {
                                                var pointData = event.point.year+' '+pointName;
                                                chartDataStack = [];
                                                chartDataStack.push(pointData);
                                            } else {
                                                pushChartDataStack(pointName);
                                            }
                                        }
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#fff',
                                borderWidth: 1,
                                borderRadius: 10,
                                borderColor: '#AAA',
                                headerFormat: null,
                                pointFormat: '<span style="color:{point.color}">{point.name}</span><br/>Total clicks: <b>{point.y:.0f}</b>'
                            },
                            series: [{
                                name: 'URLs',
                                colorByPoint: true,
                                //pointWidth: 28,
                                data: response.chartData
                            }],
                            drilldown: {
                                activeAxisLabelStyle: {
                                    textDecoration: 'none',
                                    fontStyle: 'italic',
                                    color: '#54BDDC'
                                },
                                activeDataLabelStyle: {
                                    textDecoration: 'none',
                                    fontStyle: 'italic',
                                    color: '#fff'
                                },
                                drillUpButton: {
                                    relativeTo: 'spacingBox',
                                    position: {
                                        y: 0,
                                        x: 0
                                    },
                                    theme: {
                                        fill: 'white',
                                        'stroke-width': 1,
                                        stroke: 'silver',
                                        r: 0,
                                        states: {
                                            hover: {
                                                color: '#fff',
                                                stroke: '#039',
                                                fill: '#2AABD2'
                                            },
                                            select: {
                                                color: '#fff',
                                                stroke: '#039',
                                                fill: '#bada55'
                                            }
                                        }
                                    }
                                },
                                series: [
                                @foreach ($dates as $key => $date)
                                {
                                    name: '{{ $date }}',
                                    id: '{{ $date }}',
                                    data: response.statData[{{ $key }}]
                                },
                                @endforeach
                                ]
                            }
                        });
                        @if ($subscription_status != null)
                            function pushChartDataStack(url) {
                                date = new Date(chartDataStack.pop());
                                nextDate = new Date(date.setDate(date.getDate()+1)).toISOString().slice(0, 10);
                                window.location.href = url+"/date/"+nextDate+"/analytics";
                            }
                        @endif
                    },
                    error: function(response) {
                        console.log('Response error!');
                    },
                    statusCode: {
                        500: function(response) {
                            console.log('500 Internal server error!');
                        }
                    }
                });
            }
            @else
            $.ajax({
                type: 'post',
                url: '{{ route('postFetchChartData') }}',
                data: {'user_id': '{{ $user->id }}', '_token': '{{ csrf_token() }}'},
                success: function(response) {
                    var chartDataStack = [];
                    $('#columnChart').highcharts({
                        chart: {
                            type: 'column',
                            backgroundColor: 'rgba(49, 83, 105, 1)'
                        },
                        title: {
                            text: null
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                style: {
                                    fontWeight: 'bold',
                                    color: '#fff'
                                }
                            }
                        },
                        yAxis: {
                            labels: {
                                enabled: false
                            },
                            title: {
                                text: null
                            },
                            gridLineWidth: 0,
                            minorGridLineWidth: 0
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: false,
                                    format: '{point.y:.1f}%'
                                },
                                events:{
                                    click: function (event) {
                                        var pointName = event.point.name;
                                        if (pointName.search('{{ url('/') }}')) {
                                            pushChartDataStack(pointName);
                                        } else {
                                            chartDataStack = [];
                                            chartDataStack.push(pointName);
                                        }
                                    }
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            borderWidth: 2,
                            borderRadius: 5,
                            borderColor: '{point.color}',
                            headerFormat: null,
                            pointFormat: '<span style="color:{point.color}">{point.name}</span><br/><span style="color:{point.color}">\u25A0</span> Total clicks: <b>{point.y:.0f}</b>'
                        },
                        series: [{
                            name: 'URLs',
                            colorByPoint: true,
                            //pointWidth: 50,
                            data: response.urls,    //dataset for all urls and counts
                        }],
                        drilldown: {
                            activeAxisLabelStyle: {
                                textDecoration: 'none',
                                fontStyle: 'italic',
                                color: '#ffffff'
                            },
                            activeDataLabelStyle: {
                                textDecoration: 'none',
                                fontStyle: 'italic',
                                color: '#fff'
                            },
                            drillUpButton: {
                                relativeTo: 'spacingBox',
                                position: {
                                    y: 0,
                                    x: 0
                                },
                                theme: {
                                    fill: 'white',
                                    'stroke-width': 1,
                                    stroke: 'silver',
                                    r: 0,
                                    states: {
                                        hover: {
                                            color: '#fff',
                                            stroke: '#039',
                                            fill: '#2AABD2'
                                        },
                                        select: {
                                            color: '#fff',
                                            stroke: '#039',
                                            fill: '#bada55'
                                        }
                                    }
                                }
                            },
                            series: [
                            @foreach ($urls as $key => $url)
                            {
                                name: '{{ url('/') }}/{{ $url->shorten_suffix }}',
                                id: '{{ url('/') }}/{{ $url->shorten_suffix }}',
                                data: response.urlStat[{{ $key }}]
                            },
                            @endforeach
                            ]
                        }
                    });
                    @if ($subscription_status != null)
                    function pushChartDataStack(data) {
                        chartDataStack.push(data);
                        date = new Date(chartDataStack.pop());
                        month = date.getMonth()+1;
                        isoDate = date.getFullYear()+"-"+month+"-"+date.getDate();
                        window.location.href = chartDataStack[0]+"/date/"+isoDate+"/analytics";
                    }
                    @endif
                },
                error: function(response) {
                    console.log('Response error!');
                },
                statusCode: {
                    500: function(response) {
                        console.log('500 Internal server error!');
                    }
                }
            });
            @endif
        </script>
        @if(Session::has('success'))
            <script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        title: "Success",
                        text: "{{Session::get('success')}}",
                        type: "success",
                        html: true
                    }); 
                });
            </script>
        @endif
        @if(Session::has('error'))
            <script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        title: "Error",
                        text: "{{Session::get('error')}}",
                        type: "error",
                        html: true
                    }); 
                });
            </script>
        @endif
        @if ($errors->any())
            <script>
                $(document).ready(function(){
                    swal({
                        title: "Error",
                        text: "@foreach ($errors->all() as $error){{ $error }}<br/>@endforeach",
                        type: "error",
                        html: true
                    }); 
                });
            </script>
        @endif
        <script>
            
        </script>
        <script src="{{ URL('/')}}/public/resources/js/bootstrap-datepicker.min.js"></script>
        <script>
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true,
                toggleActive: true,
                clearBtn: true,
                //startDate: '-1m',
                endDate: '+0d'
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#datePickerFrom').on('blur', function () {
                    var from = $(this).val();
                    if (from == null) {
                        $(this).focus();
                        $(this).parent().append('<p style="color: red">Start date can not be null.</p>');
                    }
                });
                $('#datePickerTo').on('blur', function () {
                    var to = $(this).val();
                    if (to ===null) {
                        $(this).focus();
                        $(this).parent().append('<p style="color: #f00">End cate can not be null.</p>');
                    }
                });
            });
        </script>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>


</body>
</html>