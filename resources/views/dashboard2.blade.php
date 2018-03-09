<!DOCTYPE html>

<!-- head of th page -->
<html lang="en">
	@include('contents/head')
<body>
<!-- head end -->

<!-- Header Start -->
@include('contents/header')
<!-- Header End -->


<!-- Banner Start -->
<div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modalclosebtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Select date range</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('getDashboard') }}" method="get" role="form" class="form" id="datePickerForm">
                    <div class="form-group">
                        <div class="input-daterange input-group" id="datepicker">
                        	<label>
	                        	<i class="fa fa-calendar" aria-hidden="true"></i>
	                            <input type="text" class="input-sm form-control" name="from" id="datePickerFrom" required />
                            </label>
                            <span class="input-group-addon">TO</span>
                            <label>
	                            <i class="fa fa-calendar" aria-hidden="true"></i>
	                            <input type="text" class="input-sm form-control" name="to" id="datePickerTo" required />
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                    	<button type="submit" id="date_form" class="btn btn-primary pull-right">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- search div -->
<div class="search-wrap">
	<div class="container">
			<div class="row">
					<div class="col-md-12 col-sm-12">
							<div class="searchpart-area">
									<div class="row">
											<div class="col-md-5 col-sm-5 less-pad">
												<div class="form-group">
														<input type="text" placeholder="Search,links" class="form-control">
												</div>
											</div>
											<div class="col-md-5 col-sm-5 less-pad">
												<div class="form-group">
													<div>
														<input type="text" data-role="tagsinput" placeholder="Search tags" class="form-control">
													</div>
												</div>
											</div>
											<div class="col-md-2 col-sm-2 less-pad">
												<div class="form-group">
														<div class="form-group">
															<button class="btn search-btn">Search</button>
														</div>
												</div>
											</div>

									</div>
							</div>
					</div>
			</div>
	</div>
</div>
<!-- search div ends -->

<section class="banner">
	{{-- populating this container with google api --}}
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
					<div class="datelink dateRangeButton">
						<a id="date_range" href="#">{{ date('M d', strtotime('-1 month')) .' - '. date('M d') }}</a>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$('.datelink a').click(function(){
								$('#datePickerModal').modal('show');
							});
						});
					</script>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="columnChart" style="height: 165px; margin: 0 auto"></div> <!-- col-md-12 graph -->
			</div>
		</div>
	</div>
</section>
<!-- Banner End -->
<!-- Main Content Start -->
<section class="main-content tabsection">
	<div class="container">
		<div class="row">
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

		                	<div class="col-sm-1">

		                 	</div>
		                 	<div class="tab-cont">
			                 	<div class="date">{{ date('M d, Y', strtotime($url->created_at)) }}</div>
			                 	<p>{{ $url->title }}</p>
			                 	@if (isset($url->subdomain))
					                @if($url->subdomain->type == 'subdomain')
					                    <a class="link" href=https://{{ $url->subdomain->name }}.{{ env('APP_HOST') }}/{{ $url->shorten_suffix }}>https://{{ $url->subdomain->name }}.{{ env('APP_HOST') }}/{{ $url->shorten_suffix }}</a>

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
											<a href="https://{{ $url->subdomain->name }}.{{ env('APP_HOST') }}/{{ $url->shorten_suffix }}" target="_blank" class="link" id="copylink{{ $key }}">
                                            https://{{ $url->subdomain->name }}.{{ env('APP_HOST') }}/{{ $url->shorten_suffix }}
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
                                            fb_share('{{ route('getIndex') }}/{{ $url->shorten_suffix }}' , '{{url('/')}}');
                                        });
                                        $('#addBrand{{ $key }}').on('click', function () {

                                            $("#urlId1").val('{{ $url->id }}');
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
                		<div class="col-md-12">
                		 	<div class="tot-clicks">
	                		 	<h2>Number of hits per country</h2>
	                		 	<div class="tot-clicks-body">
	                		 		<div id="regions_div{{ $key }}" style="width: 450px; height: 250px;"></div>
	                		 	</div>
                		 	</div>
                		</div>
                		<div class="col-md-6">
                		 	<div class="tot-clicks">
                		 		<h2>Total Clicks {{ $url->count }} (100%)</h2>
                		 		<div class="tot-clicks-body">
                		 			<div id="chart_div{{ $key }}" style="width: 350px; height: 250px;"></div>
                		 		</div>
                		 	</div>
                		</div>
                		@if ($subscription_status != null)

                			<div class="col-md-6">
	                		 	<div class="tot-clicks">
	                		 		<h2>Platform Status</h2>
	                		 		<div class="tot-clicks-body">
	                		 			<div id="platform_div{{ $key }}" style="width: 400px; height: 250px;"></div>
	                		 		</div>
	                		 	</div>
	                		</div>


	                		<div class="col-md-6">
	                		 	<div class="tot-clicks">
	                		 		<h2>Browser Status</h2>
	                		 		<div class="tot-clicks-body">
	                		 			<div id="browser_div{{ $key }}" style="width: 400px; height: 250px;"></div>
	                		 		</div>
	                		 	</div>
	                		</div>

	                		<div class="col-md-6">
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
                                    	console.log('postFetchAnalytics');
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
                        <button type="button" class="btn-primary btn-sm" data-dismiss="modal">Close </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-modal-lg in" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close modalclosebtn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="subdomainModalLabel">
                            Manage Redirecting Page Template For Your Custom Url
                        </h4>
                    </div>
                    <div class="modal-body" id="uploadModalBody">
                        <form class="form" role="form" action="{{ route('postBrandLogo') }}" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="url_id" id="urlId1" />
                            <div class="form-group">
                                <label for="brandLogo">Upload brand logo</label>
                                <input type="file" id="brandLogo1" name="brandLogo" class="form-control input-md" value="" />
                            </div>
                            <div class="form-group">
                                <label for="redirectingTime">Set redirecting time (in seconds)</label>
                                <input type="number" min="0" max="60" id="redirectingTime" name="redirectingTime" class="form-control input-md" value="" />
                            </div>
                            <div class="form-group">
                                <label for="redirectingTextTemplate">Set redirecting text template</label>
                                <textarea id="redirectingTextTemplate" name="redirectingTextTemplate" class="form-control input-md"></textarea>
                            </div>
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
                        <button type="button" class="close modalclosebtn" data-dismiss="modal" aria-label="Close">
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
        <!-- <div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
        </div> -->
        @endif

         <script>
            function editAction(key) {
                $('#editUrlTitle').on('click', function () {
                    var id = $('.modal-body #urlId').val();
                    var title = $('.modal-body #urlTitle').val();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('postEditUrlInfo') }}",
                        data: {id: id, title: title, _token: "{{ csrf_token() }}"},
                        success: function(response) {
                        	console.log('postEditUrlInfo');
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

@include('contents/footer')

<script type="text/javascript">

	$(document).ready(function() {

		$('.shortTagsContents').tagsinput({
      	allowDuplicates: false,
        // itemValue: 'id',  // this will be used to set id of tag
        // itemText: 'label' // this will be used to set text of tag
    });

		$(":checkbox").on("change", function() {

				//facebook analytics checkbox for short urls
        if (this.id === "checkboxAddFbPixelid" && this["name"] === "chk_fb_short") {
					if(this.checked) {
          	$('#fbPixelid').show();
					} else {
						$('#fbPixelid').hide();
						$('#fbPixelid').val('');
					}
        }

				//facebook analytics checkbox for custom urls
				if (this.id === "checkboxAddFbPixelid1" && this["name"] === "chk_fb_custom") {
					if(this.checked) {
						$('#fbPixelid1').show();
					} else {
						$('#fbPixelid1').hide();
						$('#fbPixelid1').val('');
					}
	      }

				//google analytics checkbox for short urls
				if (this.id === "checkboxAddGlPixelid" && this["name"] === "chk_gl_short") {
					if(this.checked) {
						$('#glPixelid').show();
					} else {
						$('#glPixelid').hide();
						$('#glPixelid').val('');
					}
	      }

				//google analytics checkbox for custom urls
				if (this.id === "checkboxAddGlPixelid1" && this["name"] === "chk_gl_custom") {
					if(this.checked) {

						$('#glPixelid1').show();
					} else {
						$('#glPixelid1').hide();
						$('#glPixelid1').val('');
					}
	      }

				//addtags for short urls
				if (this.id === "shortTagsEnable" && this["name"] === "shortTagsEnable") {
					if(this.checked) {
						$('#shortTagsArea').show();
					} else {
						$('#shortTagsArea').hide();
						$("#shortTagsContents").tagsinput('removeAll');
					}
	      }

				//addtags for custom urls
				if (this.id === "customTagsEnable" && this["name"] === "customTagsEnable") {
					if(this.checked) {
						$('#customTagsArea').show();
					} else {
						$('#customTagsArea').hide();
						$("#customTagsContents").tagsinput('removeAll');
					}
	      }

				//add short descriptions for short urls
				if (this.id === "shortDescriptionEnable" && this["name"] === "shortDescriptionEnable") {
					if(this.checked) {
						$('#shortDescriptionContents').show();
					} else {
						$('#shortDescriptionContents').hide();
						$('#shortDescriptionContents').val('');
					}
	      }

				//add short descriptions for short urls
				if (this.id === "customDescriptionEnable" && this["name"] === "customDescriptionEnable") {
					if(this.checked) {
						$('#customDescriptionContents').show();
					} else {
						$('#customDescriptionContents').hide();
						$('#customDescriptionContents').val('');
					}
				}

    });



		// $('#checkboxAddGlPixelid1, input[type="checkbox"]').on('click', function(){
		// 	if($(this).prop("checked") == true){
		// 			$('#glPixelid1').show();
    //   }
    //   else if($(this).prop("checked") == false){
		// 			$('#glPixelid1').hide();
		// 			$('#glPixelid1').val('');
    //   }
		// });
    //
		// $('#checkboxAddFbPixelid1, input[type="checkbox"]').on('click', function(){
		// 	if($(this).prop("checked") == true){
		// 			$('#fbPixelid1').show();
    //   }
    //   else if($(this).prop("checked") == false){
		// 			$('#fbPixelid1').hide();
		// 			$('#fbPixelid1').val('');
    //   }
		// });

		$(this).on('click', '.menu-icon', function(){
	    	$(this).addClass("close");
	    	$('#userdetails').slideToggle(500);
	    	$('#myNav1').hide();
	    	$('#myNav2').hide();
	    });

	    $("#basic").click(function(){
	    	$('.menu-icon').addClass("close");
	    	$('#myNav1').slideToggle(500);
	    	$('#myNav2').hide();
	    	$('#userdetails').hide();
	    });

	    $("#advanced").click(function(){
	    	$('.menu-icon').addClass("close");
	    	$('#myNav2').slideToggle(500);
	    	$('#myNav1').hide();
	    	$('#userdetails').hide();
	    });

	    $(this).on('click', '.close', function(){
        	$('.userdetails').hide();
        	$(this).removeClass("close");
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


		$.fn.modal.Constructor.prototype.enforceFocus = function() {};

		$(".list-group ul li").click(function(){
			$(this).addClass("active");
			$(".list-group ul li").not($(this)).removeClass("active");
			$(window).scrollTop(500);
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

										var checkboxAddFbPixelid 	= 	$("#checkboxAddFbPixelid1").prop('checked');
										var fbPixelid							= 	$("#fbPixelid1").val();
										var checkboxAddGlPixelid 	= 	$("#checkboxAddGlPixelid1").prop('checked');
										var glPixelid							= 	$("#glPixelid1").val();
										var allowTag							=   $("#customTagsEnable").prop('checked');
										var tags 									= 	$("#customTagsContents").tagsinput('items');
										var allowDescription      = 	$("#customDescriptionEnable").prop('checked');
										var searchDescription			= 	$("#customDescriptionContents").val();

                    $.ajax({
	                    type:"POST",
	                    url:"/check_custom",
	                    data: {custom_url: customUrl , _token:'{{csrf_token()}}'},
	                    success:function(response){
	                    	console.log('check_custom');
	                    	console.log(response);
	                    	if(response == 1)
	                    	{
	                    		console.log(response);
	                    		if (ValidURL(actualUrl))
			                    {
			                        if (ValidCustomURL(customUrl))
			                        {
			                            $.ajax({
			                                type: "POST",
			                                url: "{{ route('postCustomUrlTier5') }}",
			                                data: {
																					checkboxAddFbPixelid 	: checkboxAddFbPixelid,
																					fbPixelid							: fbPixelid,
																					checkboxAddGlPixelid 	: checkboxAddGlPixelid,
																					glPixelid 						: glPixelid,
			                                    actual_url						: actualUrl,
			                                    custom_url						: customUrl,
			                                    user_id								: userId,
																					allowTag							: allowTag,
																					tags									: tags,
																					allowDescription			: allowDescription,
																					searchDescription			: searchDescription,
			                                    _token: "{{ csrf_token() }}"
			                                }, success: function (response) {
			                                	console.log('postCustomUrlTier5');
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
	                    	}
	                    	else
	                    	{
	                    		$("#err_cust").show();
	                    		//url already used by this user
	                    	}

	                    }
	                });
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

										var checkboxAddFbPixelid 	= 	$("#checkboxAddFbPixelid").prop('checked');
										var fbPixelid							= 	$("#fbPixelid").val();
										var checkboxAddGlPixelid 	= 	$("#checkboxAddGlPixelid").prop('checked');
										var glPixelid							= 	$("#glPixelid").val();
										var allowTag							=   $("#shortTagsEnable").prop('checked');
										var tags 									= 	$("#shortTagsContents").tagsinput('items');
										var allowDescription      = 	$("#shortDescriptionEnable").prop('checked');
										var searchDescription			= 	$("#shortDescriptionContents").val();

                    if(url) {
                        if(validUrl) {
                            HoldOn.open(options);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('postShortUrlTier5') }}",
                                data: {
																	url										: url,
																	user_id								: userId,
																	checkboxAddFbPixelid 	: checkboxAddFbPixelid,
																	fbPixelid 						: fbPixelid,
																	checkboxAddGlPixelid 	: checkboxAddGlPixelid,
																	glPixelid 						: glPixelid,
																	allowTag							: allowTag,
																	tags									: tags,
																	allowDescription			: allowDescription,
																	searchDescription			: searchDescription,
																	_token: "{{ csrf_token() }}"},
                                success: function (response) {
                                	console.log('postShortUrlTier5');
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
        $(document).ready(function(){
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
                    	console.log('postChartDataFilterDateRange');
                    	console.log(response);
                    	var date_from = "{{ date( 'M d'  , strtotime($filter['start'])) }}";
                    	var date_to   = "{{ date( 'M d'  , (strtotime($filter['end']))-86400) }}";

                    	$('#date_range').text(date_from+ ' - ' +date_to);

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
                url: "{{ route('postFetchChartData') }}",
                data: {'user_id': '{{ $user->id }}', '_token': '{{ csrf_token() }}'},
                success: function(response) {
                	console.log('postFetchChartData');
                	console.log(response);
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
        });
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


		@if(\Session::has('adv'))
		<script type="text/javascript">
			$(document).ready(function(){
				swal({
                        title: "Nothing to upgrade",
                        text: "{{Session::get('adv')}}",
                        type: "info",
                        html: true
                    });
			});
		</script>
		@endif


		<script type="text/javascript">
			$(document).ready(function(){

				if (typeof(FB) != 'undefined'
		     && FB != null ) {
		    // run the app
			} else {
			    alert('check browser settings to enable facebook sharing.. ');
			}
			});
		</script>

</body>
</html>
