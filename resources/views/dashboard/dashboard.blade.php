<!DOCTYPE html>

    <!-- head of th page -->
    <html lang="en">
        @include('contents/head')
        <body>
        <!-- head end -->
        <!-- Messenger chatbot extension -->
        @include('chatbot_extension')
        <link rel="stylesheet" href="{{ URL('/')}}/public/css/selectize.legacy.css" />
        <script src="{{ URL::to('/').'/public/js/selectize.js' }}"></script>
        <script src="{{ URL::to('/').'/public/js/selectize_index.js' }}"></script>
        <!-- date time picker -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        <!-- Header Start -->
        @include('contents/header')
        <!-- Header End -->
        <div class="main-dashboard-body">
            <style>
   .width-modification  { word-wrap: normal; word-break:break-all; width: 16.33%!important; }
    th, tr{
        color: #000000
    }
    .url-description{
        overflow-y: auto;
        overflow-x: auto;
        max-height: 100px;
        max-width: 150px;
    }
</style>

@if(session()->has('edit_msg'))
    @if(session()->get('edit_msg')==0)
        <script>
            swal({
                title: "Success!",
                text: "URL has been successfully edited",
                icon: "success",
                button: "OK",
            });
        </script>
    @elseif(session()->get('edit_msg')==1)
        <script>
            swal({
                title: "Error!",
                text: "Error occurred during the editing please try again",
                icon: "warning",
                button: "OK",
            });
        </script>
    @endif
@endif
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
                                    <!-- <img src="{{url('/')}}/public/images/barcount.jpg" class="img-responsive"> -->
                        <img style="width: 30px; height: auto;" src="{{url('/')}}/public/images/chart-bar.png" class="img-responsive">
                                    <div class="count"><span>{{$count_url}}</span>Total Urls</div> <!-- ?count -->
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
<div class="search-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="searchpart-area">
                    <div class="row1">
                        <form id="dashboard-search-form" action="{{route('getDashboard')}}" method="GET">
                            <div class="col-md-5 col-sm-5 less-pad">
                                <div class="form-group">
                                    <input id="dashboard-text-to-search" value="@if(\Request::get('textToSearch')){{\Request::get('textToSearch')}}@endif" name="textToSearch" type="text" placeholder="Search links" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5 less-pad">
                                <div class="form-group">
                                    <div>
                                        <select data-placeholder="Choose a tag..." class="chosen-select tagsToSearch form-control" multiple tabindex="4" id="dashboard-tags-to-search" name="tagsToSearch[]">
                                            <option value=""></option>
                                            @for ( $i =0 ;$i<count($urlTags);$i++)
                                                <option value="{{ $urlTags[$i] }}"  @if(in_array($urlTags[$i],$tagsToSearch)) selected @endif>{{ $urlTags[$i] }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="limit" id="limit_page">
                            <div class="col-md-2 col-sm-2 less-pad">
                                <div class="form-group">
                                    <div class="form-group">
                                        <button type="button" id="dashboard-search-btn" class="btn search-btn">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content Start -->
<section class="main-content tabsection">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Click on a row to see details
                        <div class="form-group pull-right" style="margin-bottom:0;">
                            <select id="dashboard-select" class="form-control dashboard-select">
                                <option value="">Select Limit</option>
                                <option value="5"  @if( \Request::get('limit') == 5 ) selected @endif >5</option>
                                <option value="10"  @if( \Request::get('limit') == 10 ) selected @endif >10</option>
                                <option value="25" @if( \Request::get('limit') == 25 ) selected @endif >25</option>
                                <option value="50" @if( \Request::get('limit') == 50 ) selected @endif >50</option>
                                <option value="100" @if( \Request::get('limit') == 100 ) selected @endif >100</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="width-modification">Short URL</th>
                                        <th class="width-modification">Destination URL</th>
                                        <th class="width-modification"><span title="Description of the link">Description</span></th>
                                        <th>Clicks</th>
                                        <th>Created</th>
                                        <th >Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($urls as $key => $url)
                                    @php
                                        if(isset($url->subdomain)) {
                                            if($url->subdomain->type == 'subdomain')
                                                $shrt_url = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                                            else if($url->subdomain->type == 'subdirectory')
                                                $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
                                        } else {
                                            $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                                        }
                                    @endphp
                                    <tr>
                                        @if(($url->link_type==2) && ($url->parent_id==0))
                                            <td class="width-modification row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}">
                                                @if($url->actual_url != '')
                                                    <a href="{{$shrt_url}}" id="link-{{$url->id}}" target="_blank">{{$shrt_url}}</a>
                                                @else
                                                    {{$shrt_url}}
                                                @endif
                                            </td>
                                        
                                        @else
                                            <td class="width-modification row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}">

                                                <a href="{{$shrt_url}}" id="link-{{$url->id}}" target="_blank">{{$shrt_url}}</a>
                                            </td>
                                        @endif
                                        @php
                                            $actual_url = '';
                                            $has_spl_url = 'n';
                                            if($url->is_scheduled === 'y')
                                            {
                                                if(!empty($url->actual_url))
                                                {
                                                    if(strpos($url->actual_url,'https://') == 0 || strpos($url->actual_url,'http://') == 0) {
                                                        $actual_url = $url->protocol.'://'.$url->actual_url;
                                                    }
                                                    else
                                                    {
                                                        $actual_url = $url->actual_url;
                                                    }
                                                }
                                                elseif(empty($url->actual_url))
                                                {
                                                    /* check if there is special schedule available */
                                                    // for true condition
                                                    if(count($url->urlSpecialSchedules)>0)
                                                    {
                                                        foreach($url->urlSpecialSchedules as $spl_url)
                                                        {
                                                            if($spl_url->special_day == date('Y-m-d'))
                                                            {
                                                                $actual_url = $spl_url->special_day_url;
                                                                $has_spl_url = 'y';
                                                                break;
                                                            }
                                                            else
                                                            {
                                                                $has_spl_url = 'n';
                                                                $actual_url = '';
                                                            }
                                                        }
                                                    }
                                                    if(count($url->url_link_schedules)>0 && $has_spl_url == 'n')
                                                    {
                                                        // day-wise schedule
                                                        $day = date('N');
                                                        foreach ($url->url_link_schedules as $schedule)
                                                        {
                                                            if($schedule->day==$day)
                                                            {
                                                                $actual_url = $schedule->protocol.'://'.$schedule->url;
                                                                break;
                                                            }
                                                            else
                                                            {
                                                                $actual_url = '';
                                                            }
                                                        }
                                                    }
                                                    if(count($url->url_link_schedules)==0 && count($url->urlSpecialSchedules)==0)
                                                    {
                                                        $actual_url = '';
                                                    }
                                                }
                                            }
                                            elseif($url->is_scheduled === 'n')
                                            {
                                                if(strpos($url->actual_url,'https://') == 0 || strpos($url->actual_url,'http://') == 0)
                                                {
                                                    $actual_url = $url->protocol.'://'.$url->actual_url;
                                                }
                                                else
                                                {
                                                    $actual_url = $url->actual_url;
                                                }
                                            }

                                        @endphp
                                        <td class="width-modification row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}">
                                            @if(($url->link_type==2) && ($url->parent_id==0))
                                                <span class="badge badge-primary">Group Link</span>
                                            @else
                                                <a href="{{$actual_url}}" data-index"{{$url->id}}">{{$actual_url}}</a>
                                            @endif
                                        </td>
                                        <td class="width-modification row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}">
                                            <div class="url-description">
                                                @if(!empty($url->meta_description) && strlen($url->meta_description)>0)
                                                    {{$url->meta_description}}
                                                @else
                                                    {{$url->og_description}}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}">
                                            @if(($url->link_type==2) && ($url->parent_id==0))
                                                {!! Helper::getGroupTotalClickcount($url->id) !!}
                                            @else
                                                {{$url->count}}
                                            @endif
                                        </td>
                                        <td class="row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}">{{$url->created_at->format('d/m/Y')}}</td>
                                        <td class="row-{{$url->id}}">
                                            @if($url->link_type!=2)
                                            <button class='btn btn-success btn-xs copyBtn' id="copyButton" onclick="copyUrl({{$url->id}}, event)" title="Copy Url"><i class="fa fa-copy"></i></button>
                                            @endif
                                            <button class='btn btn-warning btn-xs' onclick="window.location.href = '{{route('edit_url_view',[$url->id])}}'"  ><i class="fa fa-edit"></i></button>
                                          
                                           <button class='btn btn-danger btn-xs delete-url-btn' data-id="{{ $url->id }}" title="Delete"><i class="fa fa-trash"></i></button>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{$urls->appends(request()->all())->render() }}
            </div>
        </div>
    </div>
</section>

{{-- edit modal body --}}

{{-- edit modal body --}}
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit URL</h4>
            </div>
            <form class="form-horizontal" action="{{route('edit_url')}}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <h4 id="edit_modal_header"></h4>
                    <input type="hidden" class="form-control" name="id" id="edit_modal_id" value="">
                    <input type="text" name="edited_url" id="edit_modal_edited_url" class="form-control" value="" placeholder="Enter your url here">
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <table border="0">
                            <tr width="100%">
                                <td>
                                    <input type="submit" class="btn btn-primary btn-sm" value="Confirm">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<link href="{{ URL::to('/').'/public/css/footer.css'}}" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        var inputValue = $(this).attr("value");
        $("." + inputValue).toggle();
    });
});
</script>

<script>
    /* copy url script */
    function copyUrl(row_id, event){
        var $temp = $("<input>");
        $("body").append($temp);
        var link = $("#link-"+row_id).prop("href");
        $temp.val(link).select();
        document.execCommand("copy");
        $temp.remove();
        event.stopPropagation();
        $('#link-'+row_id).css('background','#3397FA');
        $('#link-'+row_id).css('color','#FFF');
        setTimeout(function(){
            $('#link-'+row_id).css('background','');
            $('#link-'+row_id).css('color','');
        }, 1000);
    }

    /* delete url script */
    $(document).ready(function(){


        $('.delete-url-btn').click(function(event){
            event.stopPropagation();
            var delId = $(this).data('id');
            swal({
                    title: "Are you sure you want to delete this link?",
                    text: "Once deleted you will not be able to recover this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(){
                    $.get('{{route('delete_short_url')}}'+'/'+delId, function(data, status, xhr){
                        if(xhr.status==200){
                            if(data==0){
                                swal({
                                        title: "Deleted",
                                        text: "You have successfully deleted the link!",
                                        icon: "success",
                                        button: "OK",
                                    },
                                    function(){
                                        $('.row-'+delId).hide(200);
                                    }
                                );
                            }
                        }
                    });
                });
        });
    });

</script>
        </div>
        @include('contents/footer')
        <!-- Choseen jquery  -->
        <link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/prism.css' }}">
        <link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/chosen.css' }}">
        <script src="{{ URL::to('/').'/public/resources/js/chosen/chosen.jquery.js' }}" type="text/javascript"></script>
        <script src="{{ URL::to('/').'/public/resources/js/chosen/prism.js' }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ URL::to('/').'/public/resources/js/chosen/init.js' }}" type="text/javascript" charset="utf-8"></script>
        <!-- Choseen jquery  -->
        <!-- ManyChat -->
        <!-- <script src="//widget.manychat.com/216100302459827.js" async="async">
        </script> -->


        <script type="text/javascript">

        function QueryStringToJSON() {
            var pairs = location.search.slice(1).split('&');
            var result = {};
            pairs.forEach(function(pair) {
                pair = pair.split('=');
                result[pair[0]] = decodeURIComponent(pair[1] || '');
            });
            return JSON.parse(JSON.stringify(result));
        }

        var appURL = "{{url('/')}}";
        appURL = appURL.replace('https://','');
        appURL = appURL.replace('http://','');

        console.log('appURL : ',appURL);

        window.onload = function(){
            console.log('reached here');
        }

        var maintainSidebar = function(thisInstance) {
            //facebook analytics checkbox for short urls
            if (thisInstance.id === "checkboxAddFbPixelid" && thisInstance["name"] === "chk_fb_short") {
                if(thisInstance.checked) {
                    $('#fbPixelid').show();
                } else {
                    $('#fbPixelid').hide();
                    $('#fbPixelid').val('');
                }
            }

            //facebook analytics checkbox for custom urls
            if (thisInstance.id === "checkboxAddFbPixelid1" && thisInstance["name"] === "chk_fb_custom") {
                if(thisInstance.checked) {
                    $('#fbPixelid1').show();
                } else {
                    $('#fbPixelid1').hide();
                    $('#fbPixelid1').val('');
                }
            }

            //google analytics checkbox for short urls
            if (thisInstance.id === "checkboxAddGlPixelid" && thisInstance["name"] === "chk_gl_short") {
                if(thisInstance.checked) {
                    $('#glPixelid').show();
                } else {
                    $('#glPixelid').hide();
                    $('#glPixelid').val('');
                }
            }

            //google analytics checkbox for custom urls
            if (thisInstance.id === "checkboxAddGlPixelid1" && thisInstance["name"] === "chk_gl_custom") {
                if(thisInstance.checked) {

                    $('#glPixelid1').show();
                } else {
                    $('#glPixelid1').hide();
                    $('#glPixelid1').val('');
                }
            }

            //addtags for short urls
            if (thisInstance.id === "shortTagsEnable" && thisInstance["name"] === "shortTagsEnable") {
                if(thisInstance.checked) {
                    $('#shortTagsArea').show();
                } else {
                    $('#shortTagsArea').hide();
                    $("#shortTagsContents").tagsinput('removeAll');
                }
            }

            //addtags for custom urls
            if (thisInstance.id === "customTagsEnable" && thisInstance["name"] === "customTagsEnable") {
                if(thisInstance.checked) {
                    $('#customTagsArea').show();
                } else {
                    $('#customTagsArea').hide();
                    $("#customTagsContents").tagsinput('removeAll');
                }
            }

            //add short descriptions for short urls
            if (thisInstance.id === "shortDescriptionEnable" && thisInstance["name"] === "shortDescriptionEnable") {
                if(thisInstance.checked) {
                    $('#shortDescriptionContents').show();
                } else {
                    $('#shortDescriptionContents').hide();
                    $('#shortDescriptionContents').val('');
                }
            }

            //add short descriptions for short urls
            if (thisInstance.id === "customDescriptionEnable" && thisInstance["name"] === "customDescriptionEnable") {
                if(thisInstance.checked) {
                    $('#customDescriptionContents').show();
                } else {
                    $('#customDescriptionContents').hide();
                    $('#customDescriptionContents').val('');
                }
            }
        }

        $(document).ready(function() {
            $("#dashboard-search-btn").on('click',function() {
                $('#limit_page').val($('#dashboard-select').val());
                var data = $("#dashboard-search-form").serialize();
                $("#dashboard-search-form").submit();
            });

            $("#dashboard-select").on('change',function(e) {
                $('#limit_page').val(e.target.value);
                var data = $("#dashboard-search-form").serialize();
                $("#dashboard-search-form").submit();
            });

            $("#dashboard-search").on('click',function() {
                var tags = $("#dashboard-tags-to-search").tagsinput('items');
                var text = $("#dashboard-text-to-search").val();
                console.log('tags :',tags,' text: ',text);
            });

            $(":checkbox").on("change", function() {
                maintainSidebar(this);
            });

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
                        if(response == 1){
                            console.log(response);
                            if (ValidURL(actualUrl)){
                                if (ValidCustomURL(customUrl)){
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('postCustomUrlTier5') }}",
                                        data: {
                                            checkboxAddFbPixelid    : checkboxAddFbPixelid,
                                            fbPixelid               : fbPixelid,
                                            checkboxAddGlPixelid    : checkboxAddGlPixelid,
                                            glPixelid               : glPixelid,
                                            actual_url              : actualUrl,
                                            custom_url              : customUrl,
                                            user_id                 : userId,
                                            allowTag                : allowTag,
                                            tags                    : tags,
                                            allowDescription        : allowDescription,
                                            searchDescription       : searchDescription,
                                            _token                  : "{{ csrf_token() }}"
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
                                }else{
                                    swal({
                                        type: "warning",
                                        title: null,
                                        text: "Please Enter A Custom URL<br>It Should Be AlphaNumeric",
                                        html: true
                                    });
                                }
                            }else{
                                swal({
                                    type: "warning",
                                    title: null,
                                    text: "Please Enter An URL"
                                });
                            }
                        }else{
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
                var fbPixelid               =   $("#fbPixelid").val();
                var checkboxAddGlPixelid    =   $("#checkboxAddGlPixelid").prop('checked');
                var glPixelid               =   $("#glPixelid").val();
                var allowTag                =   $("#shortTagsEnable").prop('checked');
                var tags                    =   $("#shortTagsContents").tagsinput('items');
                var allowDescription        =   $("#shortDescriptionEnable").prop('checked');
                var searchDescription       =   $("#shortDescriptionContents").val();
                if(url) {
                    if(validUrl) {
                        HoldOn.open(options);
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('postShortUrlTier5') }}",
                            data: {
                                url                     : url,
                                user_id                 : userId,
                                checkboxAddFbPixelid    : checkboxAddFbPixelid,
                                fbPixelid               : fbPixelid,
                                checkboxAddGlPixelid    : checkboxAddGlPixelid,
                                glPixelid               : glPixelid,
                                allowTag                : allowTag,
                                tags                    : tags,
                                allowDescription        : allowDescription,
                                searchDescription       : searchDescription,
                                _token                  : "{{ csrf_token() }}"},
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
                    var pageLimit = $("#dashboard-select").val();
                    console.log('Page limit '+ pageLimit);
                    var qry         = QueryStringToJSON();
                    var c_page  =   1;
                    if(qry['page'] !== undefined) {
                        c_page = qry['page'];
                    }
                    $.ajax({
                        type: 'post',
                        url: "{{ route('postFetchChartData') }}",
                        data: {
                            'user_id': '{{ $user->id }}',
                            '_token': '{{ csrf_token() }}',
                            textToSearch : textToSearch,
                            tagsToSearch : tagsToSearch,
                            pageLimit    : pageLimit,
                            currentPage  : c_page
                        },
                        success: function(response) {
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
                                backgroundColor: 'rgba(68, 140, 203, 1)'
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
        <script type="text/javascript">
            $(document).ready(function(){
                /*if (typeof(FB) != 'undefined' && FB != null ) {
                // run the app
                } else {
                    alert('check browser settings to enable facebook sharing.. ');
                }*/
            });
        </script>
    </body>
</html>
