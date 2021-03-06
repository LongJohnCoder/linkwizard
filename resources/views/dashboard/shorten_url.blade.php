<!DOCTYPE html>
<html lang="en">

    <!-- head start -->
    @include('contents/head')
    <!-- head end -->
    <body>
        <!-- Messenger chatbot extension -->
        @include('chatbot_extension')
        <link rel="stylesheet" href="{{ URL('/')}}/public/css/selectize.legacy.css" />
        <link href="{{ URL::to('/').'/public/css/footer.css'}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/prism.css' }}">
        <link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/chosen.css' }}">
        <link href="{{ URL::to('/').'/public/css/fineuploader-gallery.min.css' }}" rel="stylesheet"/>
        <link href="{{ URL::to('/').'/public/css/fine-uploader-new.min.css' }}" rel="stylesheet"/>
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.common-material.min.css" />
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.min.css" />
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.mobile.min.css" />
        <style>
            .imgContainer {
            position: relative;
            width: 100%;
            max-width: 400px;
            }
            .imgContainer img {
                height: 100%;
                width: 100%;
            }
            .closeImage {
                position: absolute;
                top: 5%;
                right: 5%;
                font-size: 16px;
                background: white;
                cursor: pointer;
            }
            #customized-url-div{
                display: none;
            }
            .chosen-container-multi {
                width: 100% !important;
            }
            #error-custom-url{
                color: red;
                text-align: center;
            }
            #scheduleArea{
                padding: 10px;
            }
            .schedule-tab tr td {
                padding: 10px;
            }
            .special_url_tab tr {
                margin: 5px !important;
            }
            .special_url_tab tr td {
                padding: 5px;
            }
            .merge-tab tr td {
                padding-right: 15px;
            }
            .schedule_datepicker{
                width: 100%;
            }
            #deny-block{
                padding: 20px;
            }
        </style>
        <!-- Header Start -->
        @include('contents/header')
        <!-- Header End -->
        <div class="main-dashboard-body">
            <section class="main-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <form id="url_short_frm" action="{{route('shortenUrl')}}" method="POST" enctype="multipart/form-data" files="true" class="form form-horizaontal" role="form">
                                <input type="hidden" value="{{$type}}" name="type" id="type">
                                <input type="hidden" value="logedin" name="loggedin">
                                <!--Add URL Start-->
                                <div class="normal-box">
                                    <div class="actualUrl">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-2">
                                                @if($type==0 || $type==1)
                                                <label> Paste An Actual URL Here </label>
                                                @elseif($type==3)
                                                <label> Upload A File From Here </label>
                                                @else
                                                <label>Name Your Group </label>
                                                @endif
                                            </div>
                                            <div class="col-md-8 col-sm-8">
                                                <div class="form-group">
                                                    @if($type==0 || $type==1)
                                                    <input id="givenActual_Url_0" type="text" name="actual_url[0]" class="form-control actual-url" placeholder="Please Provide A Valid Url Like http://www.example.com">
                                                    @elseif($type==3)
                                                    <input id="inputfile" type="file" name="inputfile" class="form-control" required="true">
                                                    @else
                                                    <input id="group_url_title" type="text" name="group_url_title" class="form-control" placeholder="Group Name" required="true">
                                                    @endif
                                                </div>
                                                @if($type!=2 && $type!=3)
                                                <div class="input-msg">
                                                    * This is where you paste your long URL that you'd like to shorten.
                                                </div>
                                                @elseif($type==3)
                                                <div class="input-msg">
                                                    * This is where you can upload your file to share that you'd like to shorten.
                                                </div>
                                                <div class="input-msg">
                                                    * Maximum file size is 500MB.
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                @if($type==1)
                                                <button id="addCircularURL" class="btn-sm btn-primary"><i class="fa fa-plus fa-fw"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if ($subscription_status != null)
                                        @if(count($limit) > 0)
                                            <div class="row">
                                                <div class="col-md-2 col-sm-2">
                                                        <label> <input type="checkbox" id="custom_url_status" name="custom_url_status"> </label>
                                                </div>
                                                <div class="col-md-10 col-sm-10 input-msg">
                                                        <b>Check If You Want To Customize Url</b>
                                                </div>
                                            </div>
                                            <div id="customized-url-div">
                                                <div class="row">
                                                    <div class="col-md-2 col-sm-2">
                                                        <label> Paste Your Customized Url Name </label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">{{config('settings.APP_REDIRECT_HOST')}}
                                                                /</span>
                                                            <input id="makeCustom_Url" type="text" name="custom_url"
                                                                   class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-sm-2">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="error-custom-url">
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <!--Add URL End-->

                                <!-- Pixel manage -->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add pixel
                                            <input type="checkbox" id="managePixel" name="managePixel">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="pixels" id="pixel-ids">
                                    <div class="normal-body pixel-area">
                                        <p>Add your pixels here</p>
                                        <div class="manage_pixel_area" id="manage_pixel_area">
                                            <select class="chosen-select-pixels" data-placeholder="Choose a pixel" multiple tabindex="4" id="manage_pixel_contents" name="pixels[]">
                                                <option value=""></option>
                                                @if((count($pixels)>0) && (!empty($pixels)))
                                                    @foreach($pixelProviders as $pixelProvider)
                                                        <optgroup label="{{$pixelProvider->provider_name}}" id="{{$pixelProvider->provider_name}}">
                                                            @foreach($pixels as $key=>$pixel)
                                                                @if($pixelProvider->id == $pixel->pixel_provider_id)
                                                                    <option value="{{$pixel->id}}">{{$pixel->pixel_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- end pixel manage -->

                                <!--Add Tag Start-->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add tags
                                            <input type="checkbox" id="shortTagsEnable" name="allowTag" >
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body add-tags">
                                        <p>Mention tags for this link</p>
                                        <div class="custom-tags-area" id="customTags_Area">
                                            <select data-placeholder="Choose a tag..."
                                                    class="chosen-select chosen-select-header" multiple tabindex="4"
                                                    id="shortTags_Contents" name="tags[]">
                                                <option value=""></option>
                                                @for ( $i =0 ;$i < count($urlTags);$i++)
                                                    <option value="{{ $urlTags[$i] }}"> {{ $urlTags[$i] }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--Add Description Start-->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add description
                                            <input type="checkbox" id="descriptionEnable" name="allowDescription">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body add-description" id="descriptionArea">
                                        <p>Mention description for this link</p>
                                        <textarea id="descriptionContents" name="searchDescription"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                                <!--Add Description End-->
                                <!-- Add Countdown -->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add Customize Redirecting Page
                                            <input type="checkbox" id="countDownEnable" name="allowCustomizeUrl">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body add-countDown" id="countDownArea">
                                        <p>Add countdown time for this link <small>(in seconds)</small></p>
                                        <input type="number" min="1" max="30" id="countDownContents" name="redirecting_time" class = "form-control" value="{{$red_time/1000}}"><br>
                                        <div class="imgContainer" style="height: 180px; width: 240px;">
                                            <img id="image_preview" src="{{url('/')}}/{{$default_image}}">
                                            <span title="Set to default" class="closeImage" id="closeImage">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <p> Choose custom brand logo </p>
                                        <input class="form-control" type="file" name="custom_brand_logo" id="custom_brand_logo" accept="image/*">
                                        <span id="imageError" style="display: none; color: red">*This image is not valid. Please choose another image</span>
                                        <br><p> Select your customize colour </p>
                                        <input type="color" name="pageColour" id="pageColour" value="{{$pageColor}}">&emsp;&ensp;
                                        <span class="btn btn-primary" id="setDefaultColour" style="display: none;">Set to default colour</span><br><br>
                                        <p> Enter your redirecting text </p>
                                        <input class="form-control" type="text" name="redirecting_text_template" value="{{$redirecting_text}}" placeholder="{{$redirecting_text}}">
                                    </div>
                                </div>
                                <!-- Add Countdown End -->
                                <!-- Add Favicon -->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add favicon
                                            <input type="checkbox" id="faviconEnable" name="allowfavicon">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body add-favicon" id="faviconArea">
                                        <p>Add a favicon for this link</p>
                                        <input type="file" id="faviconContents" name="favicon_contents" class = "form-control" accept="image/*">
                                    </div>
                                </div>
                                <!-- Add Favicon End -->
                                <!--Add Link Preview Start-->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add Link Preview
                                            <input type="checkbox" id="link_preview_selector" name="link_preview_selector">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body link-preview">
                                        <ul>
                                            @if($type != 3)
                                            <li>
                                                <label class="custom-checkbox">Use Original
                                                    <input type="checkbox" checked id="link_preview_original"
                                                           name="link_preview_original">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            @endif
                                            <li class="cust-file">
                                                <label class="custom-checkbox">Use Custom
                                                    <input type="checkbox" id="link_preview_custom" name="link_preview_custom">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                        <div class="use-custom">
                                            <div class="white-paneel">
                                                <div class="white-panel-header">Image</div>
                                                <div class="white-panel-body">
                                                    <ul>
                                                        @if($type != 3)
                                                        <li>
                                                            <label class="custom-checkbox">Use Original
                                                                <input checked type="checkbox" id="org_img_chk"
                                                                       name="org_img_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <label class="custom-checkbox"><span class="cust-msg">Use Custom</span>
                                                                <input type="checkbox" id="cust_img_chk" name="cust_img_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                    <div class="use-custom1 img-inp">
                                                        <input type="file" class="form-control" id="img_inp" name="img_inp">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="white-paneel">
                                                <div class="white-panel-header">Title</div>
                                                <div class="white-panel-body">
                                                    <ul>
                                                        @if($type != 3)
                                                        <li>
                                                            <label class="custom-checkbox">Use Original
                                                                <input checked type="checkbox" id="org_title_chk"
                                                                       name="org_title_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <label class="custom-checkbox"><span class="cust-msg">Use Custom</span>
                                                                <input type="checkbox" id="cust_title_chk"
                                                                       name="cust_title_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                    <div class="use-custom1 title-inp">
                                                        <input type="text" class="form-control" id="title_inp" name="title_inp">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="white-paneel" style="border:1px dotted #00A0BA;">
                                                <div class="white-panel-header">Description</div>
                                                <div class="white-panel-body">
                                                    <ul>
                                                        @if($type != 3)
                                                        <li>
                                                            <label class="custom-checkbox">Use Original
                                                                <input checked type="checkbox" id="org_dsc_chk"
                                                                       name="org_dsc_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <label class="custom-checkbox"><span class="cust-msg">Use Custom</span>
                                                                <input type="checkbox" id="cust_dsc_chk" name="cust_dsc_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                    <div class="use-custom2 dsc-inp">
                                                        <textarea class="form-control" id="dsc_inp" name="dsc_inp"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--
                                            <div class="white-paneel">
                                                <div class="white-panel-header">URL</div>
                                                <div class="white-panel-body">
                                                    <ul>
                                                        <li>
                                                            <label class="custom-checkbox">Use Original
                                                                <input checked type="checkbox" id="org_url_chk" name="org_url_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="custom-checkbox"><span class="cust-msg">Use Custom<span>
                                                                <input type="checkbox" id="cust_url_chk" name="cust_url_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                    <div class="use-custom3 url-inp">
                                                        <input type="text" class="form-control" name="url_inp" id="url_inp">
                                                    </div>
                                                </div>
                                            </div>
                                            --}}
                                        </div>
                                    </div>
                                </div>
                                <!--Add Link Schedular-->
                                @if($type==0 || $type==1 || $type==2 || $type==3 )
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="custom-checkbox">Add expiration date for the link
                                                    <input type="checkbox" id="expirationEnable" name="allowExpiration">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            @if($type==0)
                                            <div class="col-md-4">
                                                <label class="custom-checkbox">Add schedules for the link
                                                    <input type="checkbox" id="addSchedule" name="allowSchedule">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            @endif
                                            @if($type==0 || $type==2 || $type==1 || $type==3)
                                            <div class="col-md-4">
                                                <label class="custom-checkbox">Add Geo Location
                                                    <input type="checkbox" id="addGeoLocation" name="addGeoLocation">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="normal-body add-expiration" id="expirationArea">
                                        <p>Select date &amp; time for this link</p>
                                        <input type="text" name="date_time" id="datepicker" width="100%">
                                       <!--  <input type="hidden" name="date_time" id="dt2"> -->
                                        <p>Select a timezone</p>
                                        <select name="timezone" id="expirationTZ" class="form-control">
                                            <option value="">Please select a timezone</option>
                                                @if(count($timezones)>0)
                                                    @foreach($timezones as $timezone)
                                                        <option value="{{$timezone->region}}">
                                                           {{$timezone->timezone}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                        </select>
                                        <p>Select a redirection page url after expiration</p>
                                        <input type="text" class="form-control" name="redirect_url" id="expirationUrl" onchange="checkUrl(this.value)">
                                    </div>
                                    @if( $type==0 || $type==1 )
                                    <!-- Link schedule part html -->
                                    <div class="normal-body add-link-schedule" id="scheduleArea">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#home">Daywise schedule</a></li>
                                            <li><a data-toggle="tab" href="#menu1">Special schedule</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="home" class="tab-pane fade in active">
                                                <div id="day-1">
                                                    <table class="schedule-tab" id="schedule-tab" width="100%" border="0">
                                                        <tr>
                                                            <td width="10%">
                                                                <h5 class="text-muted">Monday</h5>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="day1" id="day1" onchange="checkUrl(this.value)">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 class="text-muted">Tuesday</h5>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="day2" id="day2" onchange="checkUrl(this.value)">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 class="text-muted">Wednesday</h5>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="day3" id="day3" onchange="checkUrl(this.value)">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 class="text-muted">Thursday</h5>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="day4" id="day4" onchange="checkUrl(this.value)">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 class="text-muted">Friday</h5>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="day5" id="day5" onchange="checkUrl(this.value)">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 class="text-muted">Saturday</h5>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="day6" id="day6" onchange="checkUrl(this.value)">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 class="text-muted">Sunday</h5>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="day7" id="day7" onchange="checkUrl(this.value)">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div id="menu1" class="tab-pane fade">
                                                <input type="hidden" id="special_url_count" value="0">
                                                <table width="100%" id="special_url_tab" class="special_url_tab table-hover" border="0">
                                                    <tr id="special_url-0">
                                                        <td width="25%">
                                                            <input id="schedule_datepicker_0" class="schedule_datepicker"  class="form-control">
                                                            <input type="hidden" id="scd_id_0" name="special_date[0]">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="special_url_0" name="special_date_redirect_url[]" class="form-control" placeholder="Enter your url here" onchange="checkUrl(this.value)">
                                                        </td>

                                                        <td width="5%">
                                                            <span id="add_button_0">
                                                                <a class="btn btn-primary" onclick="addMoreSpecialLink(), dispButton(0)"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="normal-body" id="geo-location-body">
                                        <label>Set Geo Location</label>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <div id="map-div" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="checkbox" name="allow_all" id="allow-all" checked>
                                                Allow All
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="checkbox" name="deny_all" id="deny-all">
                                                Deny All
                                            </div>
                                            <div class="col-md-12 form-group" id="allowable-country">
                                            </div>
                                            <div class="col-md-12 form-group" id="denied-country">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!--Add Link Preview End-->
                                {{csrf_field()}}

                                <button type="submit" id="shorten_url_btn" class=" btn-shorten">@if($type==2) Add Group @else Shorten URL @endif</button>

                            </form>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="allow-country-modal">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close modalclosebtn" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Geolocation Settings</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row" id="allow-block">
                                        <div class="col-md-12 col-lg-12">
                                            <h4 id="allowed-country-name" style="text-align: center;"></h4>
                                            <input type="hidden" id="allowed-country-id" value="">
                                            <input type="hidden" id="allowed-country-code" value="">
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <input type="checkbox" name="allow-country" id="allow-country" style="height: 30px;">
                                        </div>
                                        <div class="col-md-10 col-lg-10">
                                            <h4> Allow </h4>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <input type="checkbox" name="allow-redirect-url-checkbox" id="allow-redirect-url-checkbox" style="height: 30px;">
                                        </div>
                                        <div class="col-md-10 col-lg-10">
                                            <h4> Redirect </h4>
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-10 col-lg-10 form-group">
                                            <input type="text" name="" id="redirect-url-allow" class="form-control" style="border:1px solid; display:none;" placeholder="PleaseEnter Redirect Url" onchange="checkUrl(this.value)">
                                        </div>
                                        <div class="col-md-12 col-lg-12">
                                            <button type="submit" class="btn btn-success" id="allow-the-country">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="deny-country-modal">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close modalclosebtn" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Geolocation Settings</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row" id="deny-block">
                                        <div class="col-md-12 col-lg-12">
                                            <h4 id="denied-country-name" style="text-align: center;"></h4>
                                            <input type="hidden" name="deny-country-code" id="deny-country-code" value="">
                                            <input type="hidden" name="deny-country-id" id="deny-country-id" value="">
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <input type="checkbox" name="deny-country" id="deny-country" style="height: 30px;">
                                        </div>
                                        <div class="col-md-10 col-lg-10">
                                            <h4> Block </h4>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <input type="checkbox" name="redirect-country" id="redirect-country" style="height: 30px;">
                                        </div>
                                        <div class="col-md-10 col-lg-10">
                                            <h4> Redirect </h4>
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-10 col-lg-10 form-group">
                                            <input type="text" name="redirect-url" id="redirect-url" class="form-control" placeholder="Please Enter Redirect Url" style="border:1px solid; display: none;" onchange="checkUrl(this.value)">
                                        </div>
                                        <div class="col-md-10 col-lg-10">
                                            <button type="button" class="btn btn-success"  id="deny-the-country">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Footer Start -->
        @include('contents/footer')
        <!-- Footer End -->

        <!-- Choseen jquery  -->
        <script src="{{ URL::to('/').'/public/resources/js/chosen/chosen.jquery.js' }}" type="text/javascript"></script>
        <script src="{{ URL::to('/').'/public/resources/js/chosen/prism.js' }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ URL::to('/').'/public/resources/js/chosen/init.js' }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ URL::to('/').'/public/js/selectize.js' }}"></script>
        <script src="{{ URL::to('/').'/public/js/selectize_index.js' }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/busy-load/dist/app.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/busy-load/dist/app.min.css" rel="stylesheet">

        <script src="{{ URL::to('/').'/public/js/createurl.js' }}"></script>
        <!-- Choseen jquery  -->

        <!-- ManyChat -->
        <!-- <script src="//widget.manychat.com/216100302459827.js" async="async"></script> -->


        <script src="{{ URL::to('/').'/public/js/fineuploader.min.js' }}"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#closeImage').hide();
            });
            /* Show 'set to default image' button in hover */
            $('.imgContainer').hover(function() {
                    var flag = $("#custom_brand_logo").val();
                    if (flag) {
                        $('#closeImage').show();
                    }
                }, function(){
                    $('#closeImage').hide();
            });
            /* Changing page colour to default */
            $('#setDefaultColour').click(function(){
                $('#pageColour').val('{{$pageColor}}');
                $('#setDefaultColour').hide();
            });
            /* Showing 'set to default colour' after changing the page colour */
            $('#pageColour').change(function() {
                $('#setDefaultColour').show();
            });
            /* Checking Image validation */
            $('#custom_brand_logo').change(function(){
                var fileName = $('#custom_brand_logo').val().split('\\').pop();
                var extension = fileName.substr( (fileName.lastIndexOf('.') +1) ).toLowerCase();
                var allowedExt = new Array("jpg","png","gif");
                if ($.inArray(extension,allowedExt) > -1) {
                    $('#imageError').hide();
                    $('#closeImage').show();
                    readImage(this);
                } else {
                    $('#imageError').show();
                    $("#custom_brand_logo").val('');
                }
            });
            function readImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#image_preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            /* setting the image to default */
            $('#closeImage').click(function() {
                $('#image_preview').attr('src', '{{url('/')}}/{{$default_image}}');
                $('#closeImage').hide();
                $("#custom_brand_logo").val('');
            });
            $(".chosen-select").chosen({});
            $(".chosen-container").bind('keyup', function (e) {
                if (e.which == 13 || e.which == 188) {
                    var lastChar = e.target.value.slice(-1);
                    var strVal = e.target.value;
                    strVal = strVal.trim();
                    if (strVal.length == 0) return false;

                    if (lastChar == ',') {
                        strVal = strVal.slice(0, -1);
                    }
                    var option = $("<option>").val(strVal).text(strVal);
                    var select = $(".chosen-select-header");
                    // Add the new option
                    select.prepend(option);
                    // Automatically select it
                    select.find(option).prop('selected', true);
                    select.trigger("chosen:updated");
                }
            });

            /* pixel manage */
            $(".chosen-select-pixels").chosen({width: "95%"});

        /* Multi network validation */
       $(".chosen-select-pixels").on('change', function(evt, el){
            var selected_value  = el.selected;
            var labelArr = [];
            $('.chosen-select-pixels').find('option').each(function(){
                if($(this).val()==selected_value) {
                    var opt_group = $(this).parent().attr('id');
                    var label = $(this).data('role');
                    labelArr.push(label);
                }
            });
            var optLabel = labelArr[0];

            /**/

            var pixels = $('#pixel-ids').val();
            if (pixels.length==0) {
                $('#pixel-ids').val(el.selected);
            } else {
                pixels = pixels+'-'+(el.selected);
                $('#pixel-ids').val(pixels);
            }

            // removing added pixel validation for onchange chosen
            $('.search-choice-close').on('click',function(){
                var remIndex = $(this).data('option-array-index');
                remIndex = parseInt(remIndex);
                var remArr = [];
                var remValArr = [];
                $('.chosen-select-pixels').find('optgroup, option').each(function(indx){
                    if (indx == remIndex) {
                        var remLabel = $(this).data('role');
                        var remVal = $(this).val();
                        remArr.push(remLabel);
                        remValArr.push(remVal);
                        var remOptlabel = remArr[0];
                        var opt_group = $(this).parent().attr('id');
                        $('#'+opt_group).find('option').each(function(){
                            if ($(this).val()!=remValArr[0]) {
                                $(this).prop('disabled', false).trigger("chosen:updated");
                            }
                        });
                    }
                });
            });
            // end of removing pixel validation for onchange chosen
        });
        /* end of pixel manage */

            var new_count;
            // Special Schedule tab add /
            function addMoreSpecialLink() {
                var special_url_count = $("#special_url_count").val();
                new_count = parseInt(special_url_count) + 1;
                $.get("{{route('ajax_schedule_tab')}}?tab_count=" + new_count, function (data, status, xhr) {
                    if (xhr.status == 200) {
                        $('#special_url_tab').append(data);
                        $('#schedule_datepicker_'+new_count).kendoDatePicker({
                            value: '',
                            min: new Date(),
                            change: onChange,
                            dateInput: false
                        });
                    }
                    $("#special_url_count").val(new_count);
                })
            }


            function onChange(){
                var scheDt = $('#schedule_datepicker_'+new_count).val();
                $('#scd_id_'+new_count).val(scheDt);
                if (new_count>0) {
                    for (var i=0; i<new_count; i++) {
                        if($('#schedule_datepicker_'+i).length>0 && scheDt == $('#schedule_datepicker_'+i).val()){
                            swal("Sorry!", "Date already given as schedule please pick another one", "warning");
                            $('#schedule_datepicker_'+new_count).val('');
                            $('#scd_id_'+new_count).val('');
                        }
                    }
                }
            }


    $(document).ready(function () {

        $("#dashboard-search-btn").on('click', function () {
            console.log('came here : submitting form');
            var data = $("#dashboard-search-form").serialize();
            $("#dashboard-search-form").submit();
        });


        $("#dashboard-search").on('click', function () {
            var tags = $("#dashboard-tags-to-search").tagsinput('items');
            var text = $("#dashboard-text-to-search").val();
            console.log('tags :', tags, ' text: ', text);
        });


        /*$("input[type='checkbox']").on("change", function () {
            maintainSidebar(this);
        });*/


        $(this).on('click', '.menu-icon', function () {
            $(this).addClass("close");
            $('#userdetails').slideToggle(500);
            $('#myNav1').hide();
            $('#myNav2').hide();
        });

        $("#basic").click(function () {
            $('.menu-icon').addClass("close");
            $('#myNav1').slideToggle(500);
            $('#myNav2').hide();
            $('#userdetails').hide();
            maintainSidebar(this);
        });

        $("#advanced").click(function () {
            $('.menu-icon').addClass("close");
            $('#myNav2').slideToggle(500);
            $('#myNav1').hide();
            $('#userdetails').hide();
            maintainSidebar(this);
        });

        $(this).on('click', '.close', function () {
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
<script src="https://kendo.cdn.telerik.com/2018.2.516/js/kendo.all.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.fn.modal.Constructor.prototype.enforceFocus = function () {
        };

        $(".list-group ul li").click(function () {
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
            theme: "custom",
            content: '<img style="width:80px;" src="{{ URL::to(' / ').' / public / resources / img / company_logo.png ' }}" class="center-block">',
            message: "Please wait a while",
            backgroundColor: "#212230"
        };


    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
            e.preventDefault();
            $(this).siblings('a.active').removeClass("active");
            $(this).addClass("active");
            var index = $(this).index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });
    });
</script>
@if(session()->has('imgErr'))
  <script type="text/javascript">alert("imgErrg");</script>
    @if(session()->get('imgErr')=='error')
        <script>
            swal({
                title: "Invalid Image format",
                text: "Please select an image with jpg png or gif file format",
                type: "warning",
                button: "OK",
            });
        </script>
    @endif
@endif
@if(Session::has('success'))
    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: "Success",
                text: "{{Session::get('success')}}",
                type: "success",
                html: true
            });
        });
    </script>
@endif @if(Session::has('error'))
    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: "Error",
                text: "{{Session::get('error')}}",
                type: "error",
                html: true
            });
        });
    </script>
@endif @if ($errors->any())
    <script>
        $(document).ready(function () {
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
<!-- <script>
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
</script> -->
<!-- <script>
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
            if (to === null) {
                $(this).focus();
                $(this).parent().append('<p style="color: #f00">End cate can not be null.</p>');
            }
        });
    });
</script> -->
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    (function (b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
            function () {
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
@if(\Session::has('adv'))
    <script type="text/javascript">
        $(document).ready(function () {
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
    /*$(document).ready(function () {
        console.log("fB"+FB);

        if (typeof(FB) != 'undefined' &&
            FB != null) {
            // run the app
        } else {
            alert('check browser settings to enable facebook sharing.. ');
        }
    });*/
</script>
 <script src="{{ URL::to('/').'/public/js/addurlshortner.js' }}"></script>
 @if($type == 3)
 <script src="{{ URL::to('/').'/public/js/file_link_preview.js' }}"></script>
 <script  type="text/javascript">
  $('.cust-msg').text('Add Custom');
 </script>
 @endif
</body>
</html>
