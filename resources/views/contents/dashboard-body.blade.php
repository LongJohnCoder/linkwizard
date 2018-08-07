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
                                        <td class="width-modification row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}"><a href="{{$shrt_url}}" id="link-{{$url->id}}" target="_blank">{{$shrt_url}}</a></td>
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
                                        <td class="width-modification row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}"><a href="{{$actual_url}}" data-index"{{$url->id}}">{{$actual_url}}</a></td>
                                        <td class="width-modification row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}">
                                            <div class="url-description">
                                                @if(!empty($url->meta_description) && strlen($url->meta_description)>0)
                                                    {{$url->meta_description}}
                                                @else
                                                    {{$url->og_description}}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}">{{$url->count}}</td>
                                        <td class="row-{{$url->id}}" onclick="window.location.href = '{{route('getLinkPreview',[$url->id])}}'" id="row-{{$url->id}}">{{$url->created_at->format('d/m/Y')}}</td>
                                        <td class="row-{{$url->id}}">
                                            afasfasdf
                                            <button class='btn btn-success btn-xs copyBtn' id="copyButton" onclick="copyUrl({{$url->id}}, event)" title="Copy Url"><i class="fa fa-copy"></i></button>
                                            <button class='btn btn-warning btn-xs'><a href="{{route('edit_url_view' , $url->id)}}" style="color: #fff;" title="Edit Url"> <i class="fa fa-edit"></i></a></button>
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