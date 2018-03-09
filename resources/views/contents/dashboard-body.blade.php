
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