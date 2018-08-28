@php
    $serverTZ = date_default_timezone_get();

@endphp
<!DOCTYPE html>
    <!-- head of th page -->
    <html lang="en">
        @include('contents/head')


        <style>
            .redirection-link-box a{
                padding-right: 5px;
            }
            .copy-btn{
                display: none;
            }
            .cp-btn{
                display: none;
            }
            #preview{
                background-color: #f7f7f7;
                border: 1px solid #999999;
                box-shadow: 2px 2px 2px #666666;
                padding: 5px;
            }
            .prev-btn{
                padding-left: 15px;
                cursor: pointer;
            }
            .prev-og-box{
                margin-top: 5px;
            }
            .prev-url{
                text-transform: uppercase;
                font-size: 12px;
                letter-spacing: 1px;
                color: #888888;
            }
            .prev-title{
                font-family: Helvetica, Arial, sans-serif;
                font-size: 17px;
                color: #1d2129;
                direction: ltr;
                line-height: 1.34;
            }
            .prev-description{
                color: #666666;
            }
            .na-url-tag{
                font-size: 10px!important;
                color: #ff6666!important;
            }
            .tags {
                list-style: none;
                margin: 0;
                overflow: hidden;
                padding: 0;
            }

            .tags li {
                float: left;
            }

            .sm-tag {
                background: #c0c0c0;
                border-radius: 3px 0 0 3px;
                color: #666666;
                display: inline-block;
                height: 26px;
                line-height: 26px;
                padding: 0 20px 0 23px;
                position: relative;
                margin: 0 10px 10px 0;
                text-decoration: none;
                -webkit-transition: color 0.2s;
            }

            .sm-tag::before {
                background: #fff;
                border-radius: 10px;
                box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
                content: '';
                height: 6px;
                left: 10px;
                position: absolute;
                width: 6px;
                top: 10px;
            }

            .sm-tag::after {
                background: #fff;
                border-bottom: 13px solid transparent;
                border-left: 10px solid #c0c0c0;
                border-top: 13px solid transparent;
                content: '';
                position: absolute;
                right: 0;
                top: 0;
            }

            .sm-tag:hover {
                background-color: #3275b2;
                color: white;
            }

            .sm-tag:hover::after {
                border-left-color: #3275b2;
            }

            .show-info-tab thead{
                background-color: #4b86b4 !important;
                color: #ffffff !important;
                height: 40px !important;
                width: 100%;
                word-wrap: break-all;
            }
            .show-info-tab{
                padding: 5px !important;
               
            }
            .link-info-date{
                font-size: 13px!important;
            }
            .no-info{
                color: #B3B3B3;
            }
            .normal-date{
                display: none;
            }
            .group-width{
                width: 280px;
                word-break: break-word;
                display: block;
            }

            #subLinkTable_info, #ipTable_info, #ipTable_previous, #ipTable_next, #subLinkTable_previous,#subLinkTable_next {
                display: none;
            }
            .ui-corner-br{
                background: #fff;
                border: 0px !important;
                text-align: center;
            }

            .dataTables_wrapper .ui-toolbar{
                padding: 0px !important;
                display: table;
            }

            .ui-widget-header{
                border: 0px !important;
            }

            .table.dataTable.no-footer{
                border: 0px !important;
            }

            .ui-state-default{
                background-color: #4b86b4 !important;
                color: #fff !important;
                border: 0px ;
            }

            .dataTables_wrapper .dataTables_paginate .fg-button{
                background-color: #fff;
                color: #337ab7;
                border: 1px solid #ddd;
            }

            .dataTables_wrapper .dataTables_paginate  .ui-state-disabled{
                background-color: #337ab7;
                color: #fff;
                border: 1px solid #337ab7;
            }

            table.dataTable tbody td {
                word-break: break-word;
                vertical-align: top;
            }
        </style>
        <body>
        <!-- head end -->

        <link rel="stylesheet" href="{{ URL('/')}}/public/css/selectize.legacy.css" />
        <script src="{{ URL::to('/').'/public/js/selectize.js' }}"></script>
        <script src="{{ URL::to('/').'/public/js/selectize_index.js' }}"></script>
        <link href="{{ URL::to('/').'/public/css/footer.css'}}" rel="stylesheet" />
        <!-- Header Start -->
        <!-- Link Preview Files -->
        <script src="{{URL::to('/').'/public/Link-Preview-master/js/linkPreview.js'}}"></script>
        <script src="{{URL::to('/').'/public/Link-Preview-master/js/linkPreviewRetrieve.js'}}"></script>
        <link href="{{URL::to('/').'/public/Link-Preview-master/css/linkPreview.css'}}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
        <!-- End Of Link Preview Files -->
        <!-- Moment JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
        <!-- End of Moment JS -->
        @include('contents/header')
        <!-- Header End -->

        @include('contents.modal.allModal')

        <!-- Messenger chatbot extension -->
        @include('chatbot_extension')

        <div class="main-dashboard-body">
            <div class="main-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#link-details">Link Details</a></li>
                                <li><a data-toggle="tab" href="#link-status">Link Status</a></li>
                                <li><a data-toggle="tab" href="#group-details" id="show-group">Group Details</a></li>
                            </ul>
                            <div class="tab-content tab-holder">
                                <div id="link-details" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2"><strong>Group:</strong></div>
                                        <div class="col-md-10 col-sm-10">
                                            <span class="redirection-link-box">
                                                <!-- <a href="{{$redirectDomain}}/{{$url->shorten_suffix}}" id="copylink"> -->{{$redirectDomain}}/{{$url->shorten_suffix}}<!-- </a> -->
                                                <!-- <a id="clipboard" class="copy-btn" data-clipboard-action="copy" data-clipboard-target="#copylink" title="Copy shorten URL"><i class="fa fa-copy"></i></a> -->
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2"><strong>Group Name</strong></div>
                                        <div class="col-md-10 col-sm-10">
                                            {{$url->title}} 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Tags of the link:</strong>
                                        </div>
                                        <div class="col-md-10">
                                            @php
                                                if(is_array($tags)){
                                                    echo '<ul class="tags">';
                                                    foreach ($tags as $tag){
                                                        echo '<li><a href="#" class="sm-tag">'.$tag.'</a></li>';
                                                    }
                                                    echo '</ul>';
                                                }else{
                                                    echo "<p class='na-url-tag'>".$tags."<p>";
                                                }
                                            @endphp
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Redirecting time:</strong>
                                        </div>
                                        <div class="col-md-10">
                                            @if($redirecting_time == 0)
                                                <span style="display: inline;">0 Seconds</span>
                                            @else
                                                {{$redirecting_time/1000}} Seconds
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Redirecting text:</strong>
                                        </div>
                                        <div class="col-md-10">
                                            @if($redirecting_time == 0)
                                                <span style="display: inline;">--</span>
                                            @else
                                                <span style="display: inline;">{{$redirecting_text}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <h5><strong><a id="prev-btn" class="prev-btn" data-toggle="collapse" data-target="#preview" title="Click hre to view your link preview">Your Link Preview  <span id="caret-icon"><i class="fa fa-caret-down"></i></span></a></strong></h5>
                                            <div class="col-md-6 col-md-offset-3">
                                                <div id="preview" class="collapse">
                                                    <div class="" id="thumbnail">
                                                        <img width="100%" height="280px" data-src = "{{$url->og_image}}" src="{{$url->og_image}}" alt="{{$url->og_image}}">
                                                    </div>

                                                    <div class="left prev-og-box" id="content">
                                                        <div class="prev-url"><a href="{{$redirectDomain}}/{{$url->shorten_suffix}}">{{str_replace(['https://','http://'], "", $redirectDomain)}}</a></div>
                                                        <div class="prev-title">
                                                            @if($url->og_title)
                                                                {{$url->og_title}}
                                                            @else
                                                                <strong>{{str_replace(['https://','http://'], "", $redirectDomain)}}</strong>
                                                            @endif
                                                        </div>
                                                        <div class="prev-description">{{$url->og_description}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <hr>
                                    <div class="tag">
                                        <ul>
                                            <li>
                                                <button id="addBrand" class="btn btn-default btn-sm btngrpthree" style="width:130px"><i class="fa fa-bullhorn"></i> Create Ad</button>
                                            </li>
                                            <li>
                                                <button id="brandLink" class="btn btn-default btn-sm btngrpthree" style="width:130px"><i class="fa fa-anchor"></i> Brand Link</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="map-area">
                                        <div id="regions_div"></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed show-info-tab" id="ipTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Date & Time</th>
                                                            <th>IP Address</th>
                                                            <th>City</th>
                                                            <th>Country</th>
                                                            <th>Browser</th>
                                                            <th>Platform</th>
                                                            <th>Referring Channel</th>
                                                            <th>Destination Url</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <strong>Link Description:</strong><br>
                                            {{$url->title}}
                                        </div>
                                    </div>
                                </div>
                                <div id="link-status" class="tab-pane fade">
                                   <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="tot-clicks">
                                                <h2>Total Clicks {!! Helper::getGroupTotalClickcount($url->id) !!}</h2>
                                                <div class="tot-clicks-body">
                                                    <div class="chart-div" id="chart_div">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="tot-clicks">
                                                <h2>Platform Status</h2>
                                                <div class="tot-clicks-body">
                                                    <div class="chart-div" id="platform_div">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="tot-clicks">
                                                <h2>Browser Status</h2>
                                                <div class="tot-clicks-body">
                                                    <div class="chart-div" id="browser_div">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="tot-clicks">
                                                <h2>Referring Chanels</h2>
                                                <div class="tot-clicks-body">
                                                    <div class="chart-div" id="referral_div">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   </div>
                                </div>
                                <div id="group-details" class="tab-pane fade">
                                    @php
                                    if(isset($url->subdomain)) {
                                        if($url->subdomain->type == 'subdomain')
                                           $shrt_url = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST');
                                        else
                                            if($url->subdomain->type == 'subdirectory')
                                               $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name;
                                    } else {
                                       $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST');
                                    }
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10"><p><strong>All links Of the Group</strong></p></div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed show-info-tab" id="subLinkTable">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">#</th>
                                                            <th width="25%">Short Link</th>
                                                            <th width="25%">Long Link</th>
                                                            <th width="5%">Count</th>
                                                            <th width="5%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($sublink)>0)
                                                            @foreach($sublink as $key =>$allSublinks)
                                                                <tr>
                                                                    <td>{{$key+1}}</td>
                                                                    <td style="word-wrap: normal;"><a class="group-width" href="{{$shrt_url}}/{{$allSublinks->shorten_suffix}}"  id="url-{{$key+1}}" >{{$shrt_url}}/{{$allSublinks->shorten_suffix}}</a></td>
                                                                    <td style="word-wrap: normal;">{{$allSublinks->protocol}}://{{$allSublinks->actual_url}}</td>
                                                                    <td>{{$allSublinks->count}}</td>
                                                                    <td> 
                                                                        <a class="btn-info btn-xs" title="Link Info" href="{{route('getLinkPreview',[$allSublinks->id])}}" target="_blank"><i class="fa fa-info"></i></a>
                                                                        <a class="btn-success btn-xs" title="Link Copy"  onclick="copyUrl({{$key+1}})"><i class="fa fa-copy"></i></a>

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="5">No Group Link Available For This Group.</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('contents/footer')

        <script>
            $(function(){
                var hash = window.location.hash;
                hash && $('ul.nav a[href="' + hash + '"]').tab('show');
                $('.nav-tabs a').click(function (e) {
                    $(this).tab('show');
                    var scrollmem = $('body').scrollTop() || $('html').scrollTop();
                    window.location.hash = this.hash;
                    $('html,body').scrollTop(scrollmem);
                });
            });

            $(function(){
                $('.redirection-link-box').mouseover(function(){
                    $('.copy-btn').show();
                });
                $('.redirection-link-box').mouseout(function(){
                    $('.copy-btn').hide();
                });

                $('.redirect-urls').mouseover(function(){
                    var cpId = $(this).data('id');
                    $('#cp-btn-'+cpId).show();
                });

                $('.redirect-urls').mouseout(function(){
                    var cpId = $(this).data('id');
                    $('#cp-btn-'+cpId).hide();
                });

                $('#prev-btn').on('click', function(){
                    var icon = $('#caret-icon i').prop('class');
                    if(icon=='fa fa-caret-up')
                    {
                        $('#caret-icon i').prop('class', 'fa fa-caret-down');
                    }else
                    {
                        $('#caret-icon i').prop('class', 'fa fa-caret-up');
                    }
                });
            });

            function copyUrl(id)
            {
                var temp = $("<input>");
                $("body").append(temp);
                var data = $('#url-'+id).prop('href');
                data = data.trim();
                temp.val(data).select();
                document.execCommand("copy");
                temp.remove();
                var node = document.getElementById('url-'+id);
                if (document.body.createTextRange) {
                    const range = document.body.createTextRange();
                    range.moveToElementText(node);
                    range.select();
                } else if (window.getSelection) {
                    const selection = window.getSelection();
                    const range = document.createRange();
                    range.selectNodeContents(node);
                    selection.removeAllRanges();
                    selection.addRange(range);
                } else {
                    console.warn("Could not select text in node: Unsupported browser.");
                }
            }
        </script>

        <script>
    
            function editAction() {
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
                            $('#urlTitleHeading').replaceWith('<h1 id="urlTitleHeading">'+response.url.title+'</div>');
                            $('#tab-title').replaceWith('<span id="tab-title" class="title">'+response.url.title+'</span>');
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


        {{-- Script for google maps --}}
        <script type="text/javascript">

                  google.charts.load('current', {'packages':['corechart', 'geochart']});
                  $.ajax({
                      url: "{{ route('postFetchAnalytics') }}",
                      type: 'POST',
                      data: {url_id: {{ $url->id }}, _token: "{{ csrf_token() }}"},
                      success: function (response) {
                        console.log(response);
                          if (response.status == "success") {
                              google.charts.setOnLoadCallback(function () {
                                  var data = google.visualization.arrayToDataTable(response.location);
                                  var options = {
                                      colorAxis: {colors: '#3366ff'},
                                      background: 'rgba(255, 255, 255, 0.8)',
                                      width   : '100%',
                                      height  : 360,
                                      margin  : 15,
                                      border  : 15,
                                      marginColor : 'black'
                                  };
                                  var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
                                  chart.draw(data, options);
                                  @if ($subscription_status != null)
                                  google.visualization.events.addListener(chart, 'select', function() {
                                      var selectionIdx = chart.getSelection()[0].row;
                                      var countryName = data.getValue(selectionIdx, 0);
                                      window.location.href = "{{ route('getIndex') }}/{{ $url->shorten_suffix }}/country/" + countryName + '/analytics';
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
                                  var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                                  chart.draw(data, options);
                                  @if ($subscription_status != null)
                                  google.visualization.events.addListener(chart, 'select', function() {
                                      var selectionIdx = chart.getSelection()[0].row;
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
                                  var chart = new google.visualization.PieChart(document.getElementById('platform_div'));
                                  chart.draw(data, options);
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
                                  var chart = new google.visualization.PieChart(document.getElementById('browser_div'));
                                  chart.draw(data, options);
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
                                  var chart = new google.visualization.PieChart(document.getElementById('referral_div'));
                                  chart.draw(data, options);
                              });
                              @endif
                          } else {
                           console.log('Response error!');
                          }
                      }
                  });
          </script>
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

        $('#clipboard').on('click', function () {
            new Clipboard('#clipboard');
        });
        $('#edit-btn').on('click', function () {
            //alert('clicked - here');
            $("#editModalBody #urlTitle").val('{{$url->title}}');
            $("#editModalBody #urlId").val('{{$url->id}}');
            $('#myModal').modal('show');
            editAction();
        });
       
        $('#addBrand').on('click', function () {
            $("#urlId1").val('{{$url->id}}');
            $("#redirectingTime").val('{{$url->redirecting_time/1000}}');
            initSummernote('{!! $url->redirecting_text_template !!}');
            $('#myModal1').modal('show');
        });
        $('#brandLink').on('click', function () {
            $("#subdomainModalBody #urlId").val('{{ $url->id }}');
            $("#subdomainBrand").val('');
            $("#subdomainAlert").text('');
            $("#subdomainRadioAlert").text('');
            $("#subdomainRadio").attr('checked',false);
            $("#subdirectoryRadio").attr('checked',false);
            $('#subdomainModal').modal('show');
        });
    });


    function editAction() {
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
                    $('#urlTitleHeading').replaceWith('<h1 id="urlTitleHeading">'+response.url.title+'</div>');
                    $('#tab-title').replaceWith('<span id="tab-title" class="title">'+response.url.title+'</span>');
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



<script type="text/javascript">


   
    $(document).ready(function() {

       
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
                maintainSidebar(this);
        });

        $("#advanced").click(function(){
            $('.menu-icon').addClass("close");
            $('#myNav2').slideToggle(500);
            $('#myNav1').hide();
            $('#userdetails').hide();
                maintainSidebar(this);
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
<script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>

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
    $('#ipTable').DataTable({
        searching: false,
        lengthChange: false,
        ajax: "{{url('/')}}/app/url/{{$url->id}}/linkDetails",
        order:[[0,"desc"]],
        autoWidth: false,
        columns : [
            { width : '50px' },
            { width : '50px' },
            { width : '50px' },        
            { width : '50px' },
            { width : '50px' },      
            { width : '50px' },      
            { width : '50px' },      
            { width : '50px' },      
        ]
    });
    $('#subLinkTable').DataTable({
        searching: false,
        ordering:  false,
        lengthChange: false,
    });

    $('#ipTable thead tr th').removeClass('ui-state-default sorting_disabled');
    $('#subLinkTable thead tr th').removeClass('ui-state-default sorting_disabled');  
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
        var checkboxAddFbPixelid    =   $("#checkboxAddFbPixelid1").prop('checked');
        var fbPixelid                           =   $("#fbPixelid1").val();
        var checkboxAddGlPixelid    =   $("#checkboxAddGlPixelid1").prop('checked');
        var glPixelid                           =   $("#glPixelid1").val();
        var allowTag                            =   $("#customTagsEnable").prop('checked');
        var tags                                    =   $("#customTagsContents").tagsinput('items');
        var allowDescription      =     $("#customDescriptionEnable").prop('checked');
        var searchDescription           =   $("#customDescriptionContents").val();
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
                                                checkboxAddFbPixelid    : checkboxAddFbPixelid,
                                                fbPixelid                           : fbPixelid,
                                                checkboxAddGlPixelid    : checkboxAddGlPixelid,
                                                glPixelid                       : glPixelid,
                                                actual_url                      : actualUrl,
                                                custom_url                      : customUrl,
                                                user_id                             : userId,
                                                allowTag                            : allowTag,
                                                tags                                    : tags,
                                                allowDescription            : allowDescription,
                                                searchDescription           : searchDescription,
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

                                        if(str.indexOf("http://") == 0) {
                                            return true;
                                        } else if(str.indexOf("https://") == 0) {
                                            return true;
                                        } else {
                                            return false;
                                        }

                    // var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|ac|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
                    // var url = str;
                    // if (!regexp.test(url)) {
                    //     return false;
                    // } else {
                    //     return true;
                    // }
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

                                        var checkboxAddFbPixelid    =   $("#checkboxAddFbPixelid").prop('checked');
                                        var fbPixelid                           =   $("#fbPixelid").val();
                                        var checkboxAddGlPixelid    =   $("#checkboxAddGlPixelid").prop('checked');
                                        var glPixelid                           =   $("#glPixelid").val();
                                        var allowTag                            =   $("#shortTagsEnable").prop('checked');
                                        var tags                                    =   $("#shortTagsContents").tagsinput('items');
                                        var allowDescription      =     $("#shortDescriptionEnable").prop('checked');
                                        var searchDescription           =   $("#shortDescriptionContents").val();

                    if(url) {
                        if(validUrl) {
                            HoldOn.open(options);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('postShortUrlTier5') }}",
                                data: {
                                                                    url                                     : url,
                                                                    user_id                             : userId,
                                                                    checkboxAddFbPixelid    : checkboxAddFbPixelid,
                                                                    fbPixelid                       : fbPixelid,
                                                                    checkboxAddGlPixelid    : checkboxAddGlPixelid,
                                                                    glPixelid                       : glPixelid,
                                                                    allowTag                            : allowTag,
                                                                    tags                                    : tags,
                                                                    allowDescription            : allowDescription,
                                                                    searchDescription           : searchDescription,
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
                                            if (pointName.search(appURL)) {
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
                                //window.location.href = url+"/date/"+nextDate+"/analytics";
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
                        var textToSearch = $("#dashboard-text-to-search").val();
                        var tagsToSearch = $("#dashboard-tags-to-search").val();
            $.ajax({
                type: 'post',
                url: "{{ route('postFetchChartData') }}",
                data: {
                                    'user_id': '{{ $user->id }}',
                                    '_token': '{{ csrf_token() }}',
                                    textToSearch : textToSearch,
                                    tagsToSearch : tagsToSearch
                                },
                success: function(response) {
                    console.log('postFetchChartData');
                    console.log(response);
                    var chartDataStack = [];
                                        var urlSeries = [];
                                        if (response.urls.length > 0) {
                                            var ur_len = response.urls.length;
                                            for(var i = 0 ; i < ur_len ; i ++) {
                                                var ur_obj = {
                                                    name    : response.urls[i]['name'],
                                                    id      :   response.urls[i]['name'],
                                                    data    :   response.urlStat[i]
                                                };
                                                urlSeries.push(ur_obj);
                                                ur_obj = null;
                                            }
                                        }
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
                            series : {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: false,
                                    format: '{point.y:.1f}%'
                                },
                                events : {
                                    click: function (event) {
                                        var pointName = event.point.name;
                                                                                //var urlToSearch = "{{url('/')}}";
                                                                                var urlToSearch = appURL;
                                        if (pointName.search(urlToSearch) == -1) {
                                                                                        console.log('searching for :',urlToSearch);
                                                                                        console.log('serach_ res',pointName.search(urlToSearch));
                                                                                        console.log('came here 1 : pointname : ',pointName);
                                                                                        console.log('');
                                            pushChartDataStack(pointName);
                                        } else {
                                                                                        console.log('searching for :',urlToSearch);
                                                                                        console.log('serach_ res',pointName.search(pointName));
                                                                                        console.log('came here 2 : pointname : ',pointName);
                                            chartDataStack = [];
                                                                                        console.log('');
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
                            series: urlSeries
                        }
                    });
                    @if ($subscription_status != null)
                    function pushChartDataStack(data) {
                                                console.log('came here 3');
                        chartDataStack.push(data);
                        date = new Date(chartDataStack.pop());
                        month = date.getMonth()+1;
                        isoDate = date.getFullYear()+"-"+month+"-"+date.getDate();
                                                console.log('location to redirect : ',chartDataStack[0]+"/date/"+isoDate+"/analytics");
                        //window.location.href = chartDataStack[0]+"/date/"+isoDate+"/analytics";
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
                        text: "{{Session::flush('success')}}",
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
                        text: "{{Session::flush('error')}}",
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

                /*if (typeof(FB) != 'undefined'
             && FB != null ) {
            // run the app
            } else {
                alert('check browser settings to enable facebook sharing.. ');
            }*/
            });

      /** Function to delete url **/

        $(function () {
            $(".delete-url").click(function (e) {
              e.preventDefault();
              var url_id = $(this).data('id');
              swal({
                  title: "Are you sure?",
                  text: "You will not be able to recover this imaginary file!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Yes, delete it!",
                  closeOnConfirm: false
                }, function (isConfirm) {
                  if (!isConfirm) return;
                  $.ajax({
                      type: "POST",
                      url: "{{ route('deleteShortenUrl') }}",
                      data: {id: url_id, _token: "{{ csrf_token() }}"},
                      success: function(response) {
                        swal({
                          title: "Success",
                          text: "Url deleted successfully.",
                          type: "success",
                          html: true
                        },function(isConfirm){
                                                    window.location.href = "{{ url('/') }}/app/user/dashboard";
                                                });
                      },
                      error: function(response) {
                          swal({
                              title: "Oops!",
                              text: "Cannot delete this url.",
                              type: "error",
                              html: true
                          });
                      }
                  });
              });
            });
        });


            /* countdown time frontend validiation */
            $(document).ready(function(){
                $('#redirectingTime').bind('keyup change click' ,function(){
                    var countDownTime = $(this).val();
                    if(countDownTime.match(/[0-9]|\./))
                    {
                        if(countDownTime<=30 && countDownTime>=1)
                        {
                            $('#redirectingTime').val(countDownTime);
                        }
                        if(countDownTime>30)
                        {
                            $('#redirectingTime').val(30);
                        }
                        if(countDownTime<=0)
                        {
                            $('#redirectingTime').val(1);
                        }


                    }else
                    {
                        swal({
                            type: 'warning',
                            title: 'Notification',
                            text: 'Countdown time should be numeric and minimum 1 & maximum 30.'
                        });
                        $('#redirectingTime').val(5);
                    }
                });
            });

        </script>

</body>
</html>
