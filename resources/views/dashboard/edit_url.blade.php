<?php
//dd($pxId);
$spanType = 'noKey';
$optTypeFB = 'normal';
$optTypeGL = 'normal';
$optTypeTWT = 'normal';
$optTypeLI = 'normal';
?>
<!DOCTYPE html>
<html lang="en">
<!-- head of the page -->
@include('contents/head')
<!-- head end -->
<!-- Messenger chatbot extension -->
@include('chatbot_extension')
<body>
<link rel="stylesheet" href="{{ URL('/')}}/public/css/selectize.legacy.css" />
<link href="{{ URL::to('/').'/public/css/footer.css'}}" rel="stylesheet" />
<script src="{{ URL::to('/').'/public/js/selectize.js' }}"></script>
<script src="{{ URL::to('/').'/public/js/selectize_index.js' }}"></script>

<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.common-material.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.mobile.min.css" />

<style type="text/css">
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
        padding: 10px;
    }
    .schedule_datepicker{
        width: 100%;
    }
</style>
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
@endif
@if(Session::has('error'))
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
@endif
@if ($errors->any())
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
<!-- Header Start -->
@include('contents/header')
<!-- Header End -->
<div class="main-dashboard-body">
    <section class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <form id="url_short_frm" action="{{route('edit_short_url', $urls->id)}}" method="POST" enctype="multipart/form-data" files=true>
                        <input type="hidden" value="{{$type}}" name="type" id="type">
                        <input type="hidden" value="logedin" name="loggedin">
                        <div class="normal-box ">
                            <div class="actualUrl">
                                <input type="hidden" id="total_no_link" value="{{$urls->no_of_circular_links}}">
                                @if($urls->link_type==1)
                                    @if($urls->no_of_circular_links==1)
                                        <div class="row">
                                            <div class="col-md-2 col-sm-2">
                                                <label>Paste An Actual URL Here</label>
                                            </div>
                                            <div class="col-md-8 col-sm-8">
                                                <input type="hidden" name="url_id[]" value="0">
                                                <input id="givenActual_Url" type="text" name="actual_url[]" class="form-control " value="{{$urls->protocol}}://{{$urls->actual_url}}" placeholder="Please Provide A Valid Url Like http://www.example.com">
                                                <div class="input-msg">* This is where you paste your long URL that you'd like to shorten.</div>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <button id="addCircularURL" class="btn-sm btn-primary"><i class="fa fa-plus fa-fw"></i></button>
                                            </div>
                                        </div>
                                    @else
                                        @if(isset($urls->circularLink) && (count($urls->circularLink)>0))
                                            @for( $i=0; $i < count($urls->circularLink); $i++)
                                                <div class="row">
                                                    <div class="col-md-2 col-sm-2">
                                                        @if($i==0)
                                                            <label>Paste An Actual URL Here</label>
                                                        @else
                                                            <label>Paste Another URL Here<label>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input type="hidden" name="url_id[]" value="{{$urls->circularLink[$i]->id}}">
                                                        <input id="givenActual_Url_{{$i}}" type="text" name="actual_url[]" class="form-control " value="{{$urls->circularLink[$i]->protocol}}://{{$urls->circularLink[$i]->actual_link}}" placeholder="Please Provide A Valid Url Like http://www.example.com">
                                                        <div class="input-msg">* This is where you paste your long URL that you'd like to shorten.</div>
                                                    </div>
                                                    <div class="col-md-2 col-sm-2">
                                                        @if($i==0)
                                                            <button id="addCircularURL" class="btn-sm btn-primary"><i class="fa fa-plus fa-fw"></i></button>
                                                        @else
                                                            <button type="button" class="btn-sm btn-primary remove-this-circular-url" ><i class="fa fa-minus fa-fw"></i></button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endfor
                                        @endif
                                    @endif
                                @elseif($urls->link_type==0)
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2">
                                            <label>Paste An Actual URL Here</label>
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            <input id="givenActual_Url" type="text" name="actual_url[0]" class="form-control " value="{{$urls->actual_url!==NULL ? $urls->protocol.'://'.$urls->actual_url : '' }}" placeholder="Please Provide A Valid Url Like http://www.example.com">
                                            <div class="input-msg">* This is where you paste your long URL that you'd like to shorten.</div>
                                        </div>

                                        <div class="col-md-2 col-sm-2">

                                        </div>
                                    </div>
                                    <div class="row"><hr>
                                        <div class="col-md-2 col-sm-2">
                                            <label>Shorten link</label>
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            <a href="//{{config('settings.APP_REDIRECT_HOST')}}/{{$urls->shorten_suffix}}" target="_blank">
                                                <p style="color: #363636">{{config('settings.APP_REDIRECT_HOST')}}/{{$urls->shorten_suffix}}</p>
                                            </a>
                                        </div>
                                    </div>
                                @elseif($urls->link_type==3)
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2">
                                            <label>Upload a file from here</label>
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            <input id="inputfile" type="file" name="inputfile" class="form-control ">
                                            <div class="input-msg">* This is where you can upload a file to share that you'd like to shorten.</div>
                                        </div>

                                        <div class="col-md-2 col-sm-2">
                                          <a href="{{$urls->protocol}}://{{$urls->actual_url}}" download>
                                            <i class="fa fa-file" aria-hidden="true" style="font-size: 50px;"></i>
                                            <!-- <span>Click to download file</span> -->
                                            <span class="row">{{$urls->title}}</span>
                                          </a>
                                        </div>
                                    </div>
                                    <div class="row"><hr>
                                        <div class="col-md-2 col-sm-2">
                                            <label>Shorten link</label>
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            <a href="//{{config('settings.APP_REDIRECT_HOST')}}/{{$urls->shorten_suffix}}" target="_blank">
                                                <p style="color: #363636">{{config('settings.APP_REDIRECT_HOST')}}/{{$urls->shorten_suffix}}</p>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2">
                                            <label>Name Your Group </label>
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            <div class="form-group">
                                                <input id="group_url_title" type="text" name="group_url_title" class="form-control" placeholder="Group Name" required="true" value="{{$urls->title}}">

                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                        </div>
                                    </div>
                                     <div class="row"><hr>
                                        <div class="col-md-2 col-sm-2">
                                            <label>Group</label>
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            @if($urls->actual_url != '')
                                                <a href="//{{config('settings.APP_REDIRECT_HOST')}}/{{$urls->shorten_suffix}}" target="_blank">
                                                    <p style="color: #363636">{{config('settings.APP_REDIRECT_HOST')}}/{{$urls->shorten_suffix}}</p>
                                                </a>
                                            @else
                                                <p style="color: #363636">{{config('settings.APP_REDIRECT_HOST')}}/{{$urls->shorten_suffix}}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Pixel manage -->
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Edit pixel
                                    <input type="checkbox" id="managePixel" name="managePixel" {{count($pixel_url)>0 ? 'checked' : ''}} >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <input type="hidden" name="pixels" id="pixel-ids">
                            <div class="normal-body pixel-area" style="display: {{count($pixel_url)>0 ?'block':''}}">
                                <p>Add your pixels here</p>
                                <div class="manage_pixel_area" id="manage_pixel_area">
                                    <select class="chosen-select-pixels" data-placeholder="Choose a pixel" multiple tabindex="4" id="manage_pixel_contents" name="pixels[]">
                                        <option value=""></option>
                                        @if(count($pixels)>0 && !empty($pixels))
                                            @foreach($pixelProviders as $pixelProvider)
                                                <optgroup label="{{$pixelProvider->provider_name}}" id="{{$pixelProvider->provider_name}}" >
                                                    @foreach($pixels as $key=>$pixel)
                                                        @if($pixelProvider->id == $pixel->pixel_provider_id)
                                                            <option value="{{$pixel->id}}"
                                                                @foreach ($pixel_url as $value)
                                                                    @if ($value->pixel_id == $pixel->id)
                                                                        selected
                                                                    @endif
                                                                @endforeach
                                                                >{{$pixel->pixel_name}}</option>
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
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Edit tags
                                    <input type="checkbox" id="shortTagsEnable" name="allowTag" <?php if(count($urls->urlTagMap)>0){echo 'checked';}?> >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @if(count($urls->urlTagMap)>0)
                                <div id="shortTags_Contents_chosen" class="chosen-container chosen-container-multi chosen-with-drop chosen-container-active" style="width: 48px; display: none;">
                                    <ul class="chosen-choices">

                                    </ul>
                                </div>
                            @endif
                            <div class="normal-body add-tags" style="display: <?php if(count($urls->urlTagMap)>0){echo 'block';}else{echo 'none';}?>">
                                <p>Mention tags for this link</p>
                                <div class="custom-tags-area" id="customTags_Area" >
                                    <input type="hidden" id="hidden_preload_tag">
                                    <select data-placeholder="" class="chosen-select chosen-select-header chosen-container" multiple tabindex="4" id="shortTags_Contents"  name="tags[]">
                                        @for ( $i =0 ;$i< count($urlTags);$i++)
                                            <option value="{{ $urlTags[$i] }}">{{ $urlTags[$i] }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Edit description
                                    <input type="checkbox" id="descriptionEnable" name="allowDescription" <?php if(isset($urls->urlSearchInfo)){echo 'checked';}?> >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body add-description" id="descriptionArea" style="display: <?php if(isset($urls->urlSearchInfo)){echo 'block';}else{ echo 'none';}?>">
                                <p>Mention description for this link</p>
                                <textarea id="descriptionContents" name="searchDescription" class = "form-control"><?php if(isset($urls->urlSearchInfo)){echo $urls->urlSearchInfo->description;}else{ echo '';}?></textarea>
                            </div>
                        </div>
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Edit Customize Redirecting Page
                                    <input type="checkbox" id="countDownEnable" name="allowCustomizeUrl" {{$urls->usedCustomised ? 'checked' : ''}} >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body add-countDown" id="countDownArea" style="display: {{$urls->usedCustomised ? 'block' : 'none'}};">
                                <p>Edit countdown time for this link <small>(in seconds)</small></p>
                                <input type="number" min="1" max="30" id="countDownContents" name="redirecting_time" class = "form-control" value="{{$red_time/1000}}" ><br>
                                <div class="imgContainer" style="height: 180px; width: 240px;">
                                    <img id="image_preview" src="{{url('/')}}/{{$current_image}}">
                                    <span title="Set to default" class="closeImage" style="display: none;" id="closeImage">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <p> Choose custom brand logo </p>
                                <input class="form-control" type="file" name="custom_brand_logo" id="custom_brand_logo" accept="image/*">
                                <span id="imageError" style="display: none; color: red">*This image is not valid. Please choose another image</span>
                                <br><p> Select your customize colour </p>
                                <input type="color" name="pageColour" id="pageColour" value="{{$pageColor}}">&emsp;&ensp;
                                <span class="btn btn-primary" id="setDefaultColour">Set to default colour</span><br><br>
                                <p> Enter your redirecting text </p>
                                <input class="form-control" type="text" name="redirecting_text_template" value="{{$redirecting_text}}" placeholder="Redirecting..."><br>
                            </div>
                        </div>
                        <!-- Edit Favicon -->
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Edit favicon
                                    <input type="checkbox" id="faviconEnable" name="allowfavicon" <?php if(!empty($urls->favicon) && strlen($urls->favicon)>0){echo 'checked';}?> >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body add-favicon" id="faviconArea" style="display: <?php if(!empty($urls->favicon) && strlen($urls->favicon)>0){echo 'block';}?>">
                                <p>Edit favicon for this link</p>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="file" id="faviconContents" name="favicon_contents" class = "form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-2">
                                        @if(!empty($urls->favicon) && strlen($urls->favicon)>0)
                                            <img class="img-responsive" style="height:40px;" src="{{$urls->favicon}}" alt="favicon" title="Your current favicon">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Favicon End -->
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Edit Link Preview
                                    <input type="checkbox" id="link_preview_selector" name="link_preview_selector"
                                    <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->usability==1){echo 'checked'; } }?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body link-preview" style="display: <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->usability==1){echo 'block'; } }else{echo 'none';}?>">
                                <ul class="cust-file">
                                    <li>
                                        <label class="custom-checkbox">Use Original
                                            <input type="checkbox" id="link_preview_original" name="link_preview_original" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->main) && $link_preview->main==0){echo 'checked'; } }else{echo '';}?> >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="custom-checkbox">Use Custom
                                            <input type="checkbox" id="link_preview_custom" name="link_preview_custom"<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->main) && $link_preview->main==1){echo 'checked'; } }else{echo '';}?> >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                                <div class="use-custom" style="display :<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->main) && $link_preview->main==1){echo 'block'; } }else{echo 'none';}?>">
                                    <div class="white-paneel">
                                        <div class="white-panel-header">Image</div>
                                        <div class="white-panel-body">
                                            <ul>
                                                <li class="cust-file">
                                                    <label class="custom-checkbox">Use Original
                                                        <input type="checkbox" id="org_img_chk" name="org_img_chk" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->image) && $link_preview->image==0){echo 'checked'; } }else{echo '';}?> >
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox"><span class="cust-msg">Use Custom</span>
                                                        <input type="checkbox" id="cust_img_chk" name="cust_img_chk" onclick="set_custom_prev_on(this.checked)" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->image) && $link_preview->image==1){echo 'checked'; } }else{echo '';}?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom1 img-inp" style="display:<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->image) && $link_preview->image==1){echo 'block'; } }else{echo 'none';}?>">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="file" class="form-control" id="img_inp" name="img_inp">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->image) && $link_preview->image==1){ ?>
                                                        <img src="{{$urls->og_image}}" class="img-responsive" style="width: 100px;">
                                                        <?php } }?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="white-paneel">
                                        <div class="white-panel-header">Title</div>
                                        <div class="white-panel-body">
                                            <ul>
                                                <li class="cust-file">
                                                    <label class="custom-checkbox">Use Original
                                                        <input type="checkbox" id="org_title_chk" name="org_title_chk"  <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->title) && $link_preview->title==0){echo 'checked'; } }else{echo '';}?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox"><span class="cust-msg">Use Custom</span>
                                                        <input type="checkbox" id="cust_title_chk" name="cust_title_chk" onclick="set_custom_prev_on(this.checked)" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->title) && $link_preview->title==1){echo 'checked'; } }else{echo '';}?> >
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom1 title-inp" style="display:<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->title) && $link_preview->title==1){echo 'block'; } }else{echo 'none';}?>">
                                                <input type="text" class="form-control" id="title_inp" name="title_inp" value="<?php echo $urls->og_title;?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="white-paneel">
                                        <div class="white-panel-header">Description</div>
                                        <div class="white-panel-body">
                                            <ul>
                                                <li class="cust-file">
                                                    <label class="custom-checkbox">Use Original
                                                        <input type="checkbox" id="org_dsc_chk" name="org_dsc_chk"  <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->description) && $link_preview->description==0){echo 'checked'; } }else{echo '';}?> >
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox"><span class="cust-msg">Use Custom</span>
                                                        <input type="checkbox" id="cust_dsc_chk" name="cust_dsc_chk"  onclick="set_custom_prev_on(this.checked)" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->description) && $link_preview->description==1){echo 'checked'; } }else{echo '';}?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom2 dsc-inp" style="display:<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if(isset($link_preview->description) && $link_preview->description==1){echo 'block'; } }else{echo 'none';}?>">
                                                <textarea class="form-control" id="dsc_inp" name="dsc_inp"><?php echo trim($urls->og_description);?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($type==0 || $type==2 || $type==3)
                            <div class="normal-box1">
                                <div class="normal-header">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="custom-checkbox">Edit expiration date for the link
                                                <input type="checkbox" id="expirationEnable" name="allowExpiration" <?php echo (!empty($urls->date_time) && $urls->is_scheduled == 'n')? 'checked' : '' ?> >
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        @if($type == 0)
                                        <div class="col-md-4">
                                            <label class="custom-checkbox">Edit schedules for the link
                                                <input type="checkbox" id="addSchedule" name="allowSchedule" <?php echo (empty($urls->date_time) && $urls->is_scheduled == 'y')? 'checked' : '' ?> >
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        @endif
                                        <div class="col-md-4">
                                            <label class="custom-checkbox">Edit Geo Location
                                                <input type="checkbox" id="editGeoLocation" name="editGeoLocation" <?php if(isset($urls->geolocation)){echo 'checked';}?>>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- expiration part html -->
                                <div class="normal-body add-expiration" id="expirationArea" style="display: <?php echo (!empty($urls->date_time) && $urls->is_scheduled == 'n')? 'block' : 'none' ?> ">
                                    <p>Select date &amp; time for this link</p>
                                    <input type="text" name="date_time" id="datepicker" width="100%" value="<?php if(!empty($urls->date_time)){echo $urls->date_time;} ?>">
                                    <p>Select a timezone</p>
                                    <select name="timezone" id="expirationTZ" class="form-control">
                                        <option value="">Please select a timezone</option>
                                        @foreach($timezones as $timezone)
                                            <option value="{{$timezone->region}}"
                                               {{$urls->timezone == $timezone->region ? 'selected' : ''}} >
                                               {{$timezone->timezone}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p>Select a redirection page url after expiration</p>
                                    <input type="text" class="form-control" name="redirect_url" id="expirationUrl" value="<?php echo(!empty($urls->redirect_url))? $urls->redirect_url : '' ?>" onchange="checkUrl(this.value)">
                                </div>
                                @if($type!=2)
                                <!-- Link schedule part html -->
                                <div class="normal-body add-link-schedule" id="scheduleArea" style="display: <?php echo (empty($urls->date_time) && $urls->is_scheduled == 'y')? 'block' : 'none' ?>">
                                    <ul class="nav nav-tabs">
                                        <li class="<?php echo ($urls->urlSpecialSchedules->count() > 0)?'' : 'active' ?>"><a data-toggle="tab" href="#home">Daywise schedule</a></li>
                                        <li class="<?php echo ($urls->urlSpecialSchedules->count() > 0)? 'active' : '' ?>"><a data-toggle="tab" href="#menu1">Special schedule</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="home" class="tab-pane fade <?php echo ($urls->urlSpecialSchedules->count() > 0)?'' : 'in active' ?>">
                                            <div id="day-1">
                                                <table class="schedule-tab" id="schedule-tab" width="100%" border="0">
                                                    <tr>
                                                        <td width="10%">
                                                            <h5 class="text-muted">Monday</h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="day1" id="day1" onchange="checkUrl(this.value)" value="<?php echo ($urls->url_link_schedules->where('day', 1)->count() > 0)? $urls->url_link_schedules->where('day', 1)->pluck('protocol')->first().'://'.$urls->url_link_schedules->where('day', 1)->pluck('url')->first() : '' ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-muted">Tuesday</h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="day2" id="day2" onchange="checkUrl(this.value)" value="<?php echo ($urls->url_link_schedules->where('day', 2)->count() > 0)? $urls->url_link_schedules->where('day', 2)->pluck('protocol')->first().'://'.$urls->url_link_schedules->where('day', 2)->pluck('url')->first() : '' ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-muted">Wednesday</h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="day3" id="day3" onchange="checkUrl(this.value)" value="<?php echo ($urls->url_link_schedules->where('day', 3)->count() > 0)? $urls->url_link_schedules->where('day', 3)->pluck('protocol')->first().'://'.$urls->url_link_schedules->where('day', 3)->pluck('url')->first() : '' ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-muted">Thursday</h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="day4" id="day4" onchange="checkUrl(this.value)" value="<?php echo ($urls->url_link_schedules->where('day', 4)->count() > 0)? $urls->url_link_schedules->where('day', 4)->pluck('protocol')->first().'://'.$urls->url_link_schedules->where('day', 4)->pluck('url')->first() : '' ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-muted">Friday</h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="day5" id="day5" onchange="checkUrl(this.value)" value="<?php echo ($urls->url_link_schedules->where('day', 5)->count() > 0)? $urls->url_link_schedules->where('day', 5)->pluck('protocol')->first().'://'.$urls->url_link_schedules->where('day', 5)->pluck('url')->first() : '' ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-muted">Saturday</h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="day6" id="day6" onchange="checkUrl(this.value)" value="<?php echo ($urls->url_link_schedules->where('day', 6)->count() > 0)? $urls->url_link_schedules->where('day', 6)->pluck('protocol')->first().'://'.$urls->url_link_schedules->where('day', 6)->pluck('url')->first() : '' ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-muted">Sunday</h5>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="day7" id="day7" onchange="checkUrl(this.value)" value="<?php echo ($urls->url_link_schedules->where('day', 7)->count() > 0)? $urls->url_link_schedules->where('day', 7)->pluck('protocol')->first().'://'.$urls->url_link_schedules->where('day', 7)->pluck('url')->first() : '' ?>">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="menu1" class="tab-pane fade <?php echo ($urls->urlSpecialSchedules->count() > 0)?'in active' : '' ?>">
                                            <input type="hidden" id="special_url_count" value="<?php echo ($urls->urlSpecialSchedules->count() > 0) ? $urls->urlSpecialSchedules->count() : 0 ?>">
                                            <input type="hidden" id="db_spl_url_count" value="{{$urls->urlSpecialSchedules->count()}}">
                                            <table width="100%" id="special_url_tab" class="special_url_tab table-hover" border="0">
                                                @if($urls->urlSpecialSchedules->count() > 0)
                                                    @foreach($urls->urlSpecialSchedules as $key => $splSchedule)
                                                        <tr id="special_url-{{$key}}">
                                                            <td width="25%">
                                                                <input id="schedule_datepicker_{{$key}}" class="schedule_datepicker"  class="form-control" value="{{date_format(date_create($splSchedule->special_day), 'm/d/Y')}}">
                                                                <input type="hidden" id="scd_id_{{$key}}" name="special_date[{{$key}}]" value="{{$splSchedule->special_day}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="special_url_{{$key}}" name="special_date_redirect_url[]" class="form-control" placeholder="Enter your url here" value="{{$splSchedule->special_day_url}}" onchange="checkUrl(this.value)">
                                                            </td>

                                                            <td width="5%">
                                                                    <span id="add_button_{{$key}}">
                                                                        @if($key==0)
                                                                            <a class="btn btn-primary" onclick="addMoreSpecialLink(), dispButton({{$key}})"><i class="fa fa-plus"></i></a>
                                                                        @else
                                                                            <a class="btn btn-primary" onclick="delTabRow({{$key}})"><i class="fa fa-minus"></i></a>
                                                                        @endif
                                                                    </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @elseif($urls->urlSpecialSchedules->count() == 0)
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
                                                @endif
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                @endif
                                <div class="normal-body" id="geo-location-body" style="display:<?php if(isset($urls->geolocation)){echo 'block';}else{echo 'none';}?>">
                                    <label>Geo Location</label>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <div id="map-div" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input type="checkbox" name="allow_all" id="allow-all" @if(isset($urls->geolocation) && ($urls->geolocation==0)) {{'checked'}} @elseif(!isset($urls->geolocation)){{'checked'}} @elseif(isset($urls->geolocation) && ($urls->geolocation=="")){{'checked'}} @endif>
                                            Allow All
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input type="checkbox" name="deny_all" id="deny-all" @if(isset($urls->geolocation) && ($urls->geolocation==1)) {{'checked'}} @endif>
                                            Block All
                                        </div>
                                        <div class="col-md-12 form-group" id="allowable-country">
                                        @if(isset($urls->geolocation) && ($urls->geolocation==1))
                                            @if($urls->getGeoLocation->count() > 0)
                                                @foreach ($urls->getGeoLocation as $locationDetails)
                                                    <div id="{{$locationDetails->country_name}}">
                                                        <input type='hidden' name='denyCountryName[]' value='{{$locationDetails->country_name}}'>
                                                        <input type='hidden' name='denyCountryCode[]' value='{{$locationDetails->country_code}}'>
                                                        <input type='hidden' name='denyCountryId[]' value='0'>
                                                        <input type='hidden' name='allowed[]' value='{{$locationDetails->allow}}'>
                                                        <input type='hidden' name='denied[]' value='{{$locationDetails->deny}}'>
                                                        <input type='hidden' name='redirect[]' value='{{$locationDetails->redirection}}'>
                                                        <input type='hidden' name='redirectUrl[]' value='{{$locationDetails->url}}'>
                                                    </div>

                                                @endforeach
                                            @endif
                                        @endif
                                        </div>
                                        <div class="col-md-12 form-group" id="denied-country">
                                        @if(isset($urls->geolocation) && ($urls->geolocation==0))
                                            @if($urls->getGeoLocation->count() > 0)
                                                @foreach ($urls->getGeoLocation as $locationDetails)
                                                    <div id="{{$locationDetails->country_name}}">
                                                        <input type='hidden' name='denyCountryName[]' value='{{$locationDetails->country_name}}'>
                                                        <input type='hidden' name='denyCountryCode[]' value='{{$locationDetails->country_code}}'>
                                                        <input type='hidden' name='denyCountryId[]' value='0'>
                                                        <input type='hidden' name='allowed[]' value='{{$locationDetails->allow}}'>
                                                        <input type='hidden' name='denied[]' value='{{$locationDetails->deny}}'>
                                                        <input type='hidden' name='redirect[]' value='{{$locationDetails->redirection}}'>
                                                        <input type='hidden' name='redirectUrl[]' value='{{$locationDetails->url}}'>
                                                    </div>

                                                @endforeach
                                            @endif

                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                        {{csrf_field()}}
                        <button type="submit" id="edit-short-url" class=" btn-shorten">@if($type==2) Edit Group @else Update URL @endif</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
                 <div class="modal fade" id="allow-country-modal">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Geolocation Edit</h4>
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
                                        <div class="col-md-2 col-lg-2">
                                        </div>
                                        <div class="col-md-10 col-lg-10 form-group">
                                            <input type="text" name="" id="redirect-url-allow" class="form-control" style="display:none;" placeholder="Enter Redirect Url" onchange="checkUrl(this.value)">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn-success" id="allow-the-country">Save changes</button>
                                    <button type="button" class="btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="deny-country-modal">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Geolocation Edit</h4>
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
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-success"  id="deny-the-country">Save changes</button>
                                    <button type="button" class="btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
</div>
@include('contents/footer')
<!-- Choseen jquery  -->
<link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/prism.css' }}">
<link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/chosen.css' }}">
<script src="{{ URL::to('/').'/public/resources/js/chosen/chosen.jquery.js' }}" type="text/javascript"></script>
<script src="{{ URL::to('/').'/public/resources/js/chosen/prism.js' }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ URL::to('/').'/public/resources/js/chosen/init.js' }}" type="text/javascript" charset="utf-8"></script>

<script src="https://kendo.cdn.telerik.com/2018.2.516/js/kendo.all.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/busy-load/dist/app.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/busy-load/dist/app.min.css" rel="stylesheet">

<!-- Choseen jquery  -->
<style type="text/css">
    .chosen-container-multi {
        width:100% !important;
    }
</style>
<!-- ManyChat -->
<!-- <script src="//widget.manychat.com/216100302459827.js" async="async">
</script> -->


<script src="{{ URL::to('/').'/public/js/fineuploader.min.js' }}"></script>
<link href="{{ URL::to('/').'/public/css/fineuploader-gallery.min.css' }}" rel="stylesheet" />
<link href="{{ URL::to('/').'/public/css/fine-uploader-new.min.css' }}" rel="stylesheet" />

<script>
    $(document).ready(function(){
        if ('{{$default_image}}' == '{{$current_image}}') {
            $('#closeImage').hide();
        }
    });
</script>
<script type="text/javascript">
    /* Show 'set to default image' button in hover */
    $('.imgContainer').hover(function() {
        var file = $('#image_preview').attr('src');
        if (file != '{{url('/')}}/{{$default_image}}') {
            $('#closeImage').show();
        }
        }, function() {
            $('#closeImage').hide();
    });
    /* Changing page colour to default */
    $('#setDefaultColour').click(function(){
        $('#pageColour').val('{{$default_colour}}');
        $('#setDefaultColour').hide();
    });
    /* Checking Image validation */
    $('#custom_brand_logo').change(function() {
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
            $('#image_preview').attr('src', '{{url('/')}}/{{$current_image}}');
        }
    });

    /* setting the image to default */
    $('#closeImage').click(function() {
        $('#image_preview').attr('src', '{{url('/')}}/{{$default_image}}');
        $('#closeImage').hide();
        $("#custom_brand_logo").val('');
    });
    /* Showing 'set to default colour' after changing the page colour */
    $('#pageColour').change(function() {
        $('#setDefaultColour').show();
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
    function addMoreSpecialLink() {
        var special_url_count = $("#special_url_count").val();
        var new_count;
        if(special_url_count>0)
        {
            new_count = parseInt(special_url_count);
        }
        else if(special_url_count==0)
        {
            new_count = parseInt(special_url_count)+1;
        }
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
            $("#special_url_count").val(new_count+1);
        })

        function onChange()
        {
            var scheDt = $('#schedule_datepicker_'+new_count).val();
            $('#scd_id_'+new_count).val(scheDt);

            if(new_count>0)
            {
                for(var i=0; i<new_count; i++)
                {
                    if($('#schedule_datepicker_'+i).length>0 && scheDt == $('#schedule_datepicker_'+i).val())
                    {
                        swal("Sorry!", "Date already given as schedule please pick another one", "warning");
                        $('#schedule_datepicker_'+new_count).val('');
                        $('#scd_id_'+new_count).val('');


                    }
                }
            }
        }
    }


    $(document).ready(function () {



// create DateTimePicker from input HTML element
            <?php
            if($urls->date_time !== NULL)
            {
                $expiryDate = $urls->date_time;
                $null_check = 0;
            }
            elseif($urls->date_time === NULL)
            {
                $expiryDate = date('Y-m-d h:i:s A');
                $null_check = 1;
            }
            ?>

        var expirtaionDateTime = "{{$expiryDate}}";
        var t = expirtaionDateTime.split(/[- :]/);
        var null_check = {{$null_check}};
        $("#datepicker").kendoDateTimePicker({
            value: (null_check==0)?new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0):'',
            min: new Date(),
            dateInput: true,
            interval: 5
        });
        $("#datepicker").bind("click", function(){
            $(this).data("kendoDateTimePicker").open( function(){
                $("#datepicker").bind("click", function(){
                    $(this).data("kendoTimePicker").open();
                });
            });
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
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var pixels = $("#manage_pixel_contents").val();
        var tests = $('.chosen-select-pixels').val();
        console.log(pixels,tests);
        $.each(pixels, function(remIndex){
            //fds
        });
    });
</script>
<script>
    $(document).on('ready readyAgain', function(){
        // removing added pixel validation
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
        // end of removing pixel validation
    });
</script>

<script type="text/javascript">
    $("#shortTags_Contents").chosen(
        {no_results_text: "No result found. Press enter to add "}
    );
    var selectedTag = [];

    @if(count($selectedTags)>0)
    @foreach($selectedTags as $tags )
    selectedTag.push('{{$tags->urlTag[0]->tag}}');
    @endforeach
    @endif
    $('#shortTags_Contents').val(selectedTag).trigger('chosen:updated');


    /* custom original checkbox set */
    function set_custom_prev_on(chk)
    {
        if(chk==true)
        {
            $("#link_preview_original").attr('checked', false);
            $("#link_preview_custom").attr('checked', true);
        }

    }

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
        //      return false;
        // } else {
        //      return true;
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

    // var manualUploader = new qq.FineUploader({
    //             element: document.getElementById('img_inp'),
    //             //template: 'qq-template-manual-trigger',
    //             request: {
    //                 endpoint: "{{route('imgUploader')}}"
    //             },
    //             thumbnails: {
    //                 placeholders: {
    //                     waitingPath: '/source/placeholders/waiting-generic.png',
    //                     notAvailablePath: '/source/placeholders/not_available-generic.png'
    //                 }
    //             },
    //             autoUpload: false,
    //             debug: true
    //         });

    // $("#url_short_frm").submit(function(e) {
    //     e.preventDefault();
    //      var formData = new FormData(this);
    //      //console.log('form data :',formData);
    //
    //     $.ajax({
    //         url: "{{route('shortenUrl')}}",
    //         type: 'POST',
    //         data: formData,
    //         success: function (data) {
    //             console.log(data)
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    // });

    // var allowedSizes = {
    //  x :
    // }

    /* var shortenUrlFunc = function() {
         var urlToHit = @if($type == 'short') "{{ route('postShortUrlTier5') }}" @elseif($type == 'custom')  "{{ route('postCustomUrlTier5') }}" @endif;

        var actualUrl = $('#givenActual_Url').val();*/

    // var _URL = window.URL || window.webkitURL;
    // $("#img_inp").change(function (e) {
    //     var file, img;
    //     if ( this.files !== null && this.files[0] !== null && this.files[0] !== undefined && (file = this.files[0])) {
    //         img = new Image();
    //         img.onload = function () {
    //             alert(this.width + " " + this.height);
    //         };
    //         img.src = _URL.createObjectURL(file);
    //     }
    // });

    /*var customUrl = null;
@if($type == 'custom')
    customUrl = $('#makeCustom_Url').val();
@endif
    $("#url_short_frm").submit();
}*/



    /*$("#shorten_url_btn").on('click',function(e){

        if($("#cust_url_chk").prop('checked') && $("#link_preview_selector").prop('checked') && $("#link_preview_custom").prop('checked')) {
            var url_inp_len = $("#url_inp").val().trim().length;
            var url_inp         = $("#url_inp").val();
            if(url_inp.indexOf(' ') != -1 ||
                (!(url_inp.indexOf('http://') == 0) && !(url_inp.indexOf('https://') == 0)) ||
                (url_inp.indexOf(',') != -1) ||
                (url_inp.indexOf(';') != -1)) {
                swal({
                    type: "warning",
                    title: null,
                    text: "Please give a proper url in your link preview url section",
                    html: true
                });
                return false;
            }
        }

        /*  expiration validation  */
    /*if($('#expirationEnable').prop('checked'))
    {
        if($('#datepicker').val()!='')
        {
            if($('#expirationTZ').val()!='')
            {

            }
            else
            {
                swal({
                    type: "warning",
                    title: null,
                    text: "Please pick a timezone & time for link expiration",
                    html: true
                });
                return false;
            }
        }
        else
        {
            swal({
                type: "warning",
                title: null,
                text: "Please pick a time for link expiration",
                html: true
            });
            return false;
        }
    }



    var actualUrl = $('#givenActual_Url').val();
    var customUrl = $('#makeCustom_Url').val();
@if (Auth::user())
    var userId = {{ Auth::user()->id }};
                @else
    var userId = 0;
@endif

    var cust_url_flag = "{{$type}}";


        if(cust_url_flag == 'custom') {

            $.ajax({
                type:"POST",
                url:"/check_custom",
                data: {custom_url: customUrl , _token:'{{csrf_token()}}'},
                success:function(response){
                    if(response == 1)
                    {
                        console.log(response);
                        if (ValidURL(actualUrl))
                        {
                            if (ValidCustomURL(customUrl))
                            {
                                shortenUrlFunc();
                            }
                            else
                            {
                                swal({
                                    type: "warning",
                                    title: 'Incorrect url',
                                    text: "Please Enter A Custom URL<br>It Should Be AlphaNumeric",
                                    html: true
                                });
                            }
                        }
                        else
                        {
                            swal({
                                type: "warning",
                                title: 'Url not found',
                                text: "Please Enter An URL"
                            });
                        }
                    }
                    else
                    {
                        swal({
                            type: "warning",
                            title: 'Sorry this url is taken',
                            text: "This custom url name is already taken! Try another one"
                        });
                        //url already used by this user
                    }

                }
            });
        } else {

            //if it is not custom
            if (ValidURL(actualUrl))
            {
                shortenUrlFunc();
            }
            else
            {
                swal({
                    type: "warning",
                    title: 'URl not found',
                    text: "Please Enter An URL"
                });
            }
        }
    });*/

    /*var appURL = "{{url('/')}}";
    appURL = appURL.replace('https://','');
    appURL = appURL.replace('http://','');*/


    /*window.onload = function(){*/
    /*console.log('reached here');*/
    //giveMyTags();
    /*}*/

    // var $select = $('#shortTagsContentss').selectize({
    //              maxItems: null,
    //              valueField: 'tag',
    //              labelField: 'tag',
    //              searchField: 'tag',
    //              options: [
    //                  {tag: 'tag1'},{tag:'tag2'},{tag:'tag3'}
    //              ],
    //              create: true
    //          });

    var maintainSidebar = function(thisInstance) {

        //for url
        if(thisInstance.id === "org_url_chk") {
            if(thisInstance.checked) {
                $('.url-inp').hide();
                $('#url_inp').val('');
                $('#url_inp').hide();
                $("#cust_url_chk").attr("checked",false);
            } else {
            }
        }

        if(thisInstance.id === "cust_url_chk") {
            if(thisInstance.checked) {
                $('.url-inp').show();
                $('#url_inp').show();
                $("#org_url_chk").attr("checked",false);
            } else {
                $('.url-inp').hide();
                $('#url_inp').hide();
                $('#url_inp').val('');
            }
        }

        //for description
        if(thisInstance.id === "org_dsc_chk") {
            if(thisInstance.checked) {
                $('.dsc-inp').hide();
                $('#dsc_inp').val('');
                $('#dsc_inp').hide();
                $("#cust_dsc_chk").attr("checked",false);
            } else {
            }
        }

        if(thisInstance.id === "cust_dsc_chk") {
            if(thisInstance.checked) {
                $('.dsc-inp').show();
                $('#dsc_inp').show();
                $("#org_dsc_chk").attr("checked",false);
            } else {
                $('.dsc-inp').hide();
                $('#dsc_inp').hide();
                $('#dsc_inp').val('');
            }
        }

        //for title
        if(thisInstance.id === "org_title_chk") {
            if(thisInstance.checked) {
                $('.title-inp').hide();
                $('#title_inp').val('');
                $('#title_inp').hide();
                $("#cust_title_chk").attr("checked",false);
            } else {
            }
        }

        if(thisInstance.id === "cust_title_chk") {
            if(thisInstance.checked) {
                $('.title-inp').show();
                $('#title_inp').show();
                $("#org_title_chk").attr("checked",false);
            } else {
                $('.title-inp').hide();
                $('#title_inp').hide();
                $('#title_inp').val('');
            }
        }

        //for image
        if(thisInstance.id === "org_img_chk") {
            if(thisInstance.checked) {
                $('.img-inp').hide();
                $('#img_inp').val('');
                $('#img_inp').hide();
                $("#cust_img_chk").attr("checked",false);
            } else {
            }
        }

        if(thisInstance.id === "cust_img_chk") {
            if(thisInstance.checked) {
                $('.img-inp').show();
                $('#img_inp').show();
                $("#org_img_chk").attr("checked",false);
            } else {
                $('.img-inp').hide();
                $('#img_inp').hide();
                $('#img_inp').val('');
            }
        }

        //alert(1234);
        //facebook analytics checkbox for short urls
        if (thisInstance.id === "checkboxAddFbPixelid") {
            if(thisInstance.checked) {
                $('.facebook-pixel').show();
                $('#fbPixel_id').show();
            } else {

                $('.facebook-pixel').hide();
                $('#fbPixel_id').val('');
                $('#fbPixel_id').hide();
            }
        }

        //facebook analytics checkbox for custom urls
        // if (thisInstance.id === "checkboxAddFbPixelid1" && thisInstance["name"] === "chk_fb_custom") {
        //  if(thisInstance.checked) {
        //      $('#fbPixelid1').show();
        //  } else {
        //      $('#fbPixelid1').hide();
        //      $('#fbPixelid1').val('');
        //  }
        // }

        //google analytics checkbox for short urls
        // if (thisInstance.id === "checkboxAddGlPixelid" && thisInstance["name"] === "chk_gl_short") {
        //  if(thisInstance.checked) {
        //      $('#glPixelid').show();
        //  } else {
        //      $('#glPixelid').hide();
        //      $('#glPixelid').val('');
        //  }
        // }

        //google analytics checkbox for custom urls
        if (thisInstance.id === "checkboxAddGlPixelid") {
            if(thisInstance.checked) {
                $('.google-pixel').show();
                $('#glPixel_id').show();
            } else {
                $('.google-pixel').hide();
                $('#glPixel_id').hide();
                $('#glPixel_id').val('');
            }
        }

        /* Manage Pixel */
        if (thisInstance.id=="managePixel") {
            if (thisInstance.checked) {
                $('.pixel-area').show();
                $('#manage_pixel_area').show();
            } else {
                $('.pixel-area').hide();
                $('#manage_pixel_area').hide();
                $('#manage_pixel_contents').val('');
                var select = $('.chosen-select-pixels');
                select.find('option').prop('selected', false);
                select.trigger("chosen:updated");
            }
        }

        //addtags for short urls

        if (thisInstance.id === "shortTagsEnable") {
            if(thisInstance.checked) {

                $('.add-tags').show();
                $('#shortTags_Area').show();
            } else {
                $('.add-tags').hide();
                $('#shortTags_Area').hide();
                $("#shortTags_Contents").val('');
                var select = $(".chosen-select-header");
                select.find('option').prop('selected', false);
                select.trigger("chosen:updated");

            }
        }


        if (thisInstance.id === "descriptionEnable") {
            if(thisInstance.checked) {
                $('#descriptionArea').show();
                $('#descriptionContents').show();
            } else {
                $('#descriptionContents').hide();
                $('#descriptionContents').val('');
                $('#descriptionArea').hide();
            }
        }

        if (thisInstance.id === "countDownEnable")
        {
            if(thisInstance.checked){
                $('#countDownArea').show();
                $('#countDownContents').show();
            } else{
                $('#countDownArea').hide();
                $('#countDownContents').val('');
                $('#countDownContents').hide();
            }
        }

        //Edit favicon
        if(thisInstance.id=="faviconEnable")
        {
            if(thisInstance.checked){
                $('#faviconArea').show();
                $('#faviconContents').show();
            } else{
                $('#faviconArea').hide();
                $('#faviconContents').val('');
                $('#faviconContents').hide();
            }
        }

        //Expire Link
        if (thisInstance.id === "expirationEnable") {
            if (thisInstance.checked) {
                $('#expirationArea').show();
                $('#datepicker').prop('required', true);
                $('#expirationTZ').prop('required', true);
                var dt = $("#datepicker").val();
                $("#dt2").val(dt);
            } else {
                $('#datepicker').val('');
                $('#expirationTZ').val('');
                $('#expirationUrl').val('');
                $('#expirationArea').hide();
                $("#dt2").val('');
                $('#datepicker').prop('required', false);
                $('#expirationTZ').prop('required', false);
            }
            $('#scheduleArea').hide();
        }


        if (thisInstance.id === 'addSchedule') {
            if (thisInstance.checked) {
                $('#scheduleArea').show();
            } else {
                $('#scheduleArea').hide();
                $('#day1').val('');
                $('#day2').val('');
                $('#day3').val('');
                $('#day4').val('');
                $('#day5').val('');
                $('#day6').val('');
                $('#day7').val('');
            }
        }

        if(thisInstance.id === "link_preview_selector" && thisInstance["name"] === "link_preview_selector") {
            if(thisInstance.checked) {
                $('.link-preview').show();
            } else {
                $('.link-preview').hide();
            }
        }

        if(thisInstance.id === 'link_preview_original') {
            if(thisInstance.checked) {
                $('#link_preview_custom').attr("checked", false);
                $('.use-custom').hide();
            } else {
                //$('#link_preview_').hide();
                //$('#link_preview_original').hide();
            }
        }

        if(thisInstance.id === 'link_preview_custom') {
            if(thisInstance.checked) {
                $('.use-custom').show();
                $('#link_preview_original').attr("checked",false);
            } else {
                //$('#link_preview_').hide();
                $('.use-custom').hide();
            }
        }

    }

    /* countdown time frontend validiation */
    $(document).ready(function(){
        $('#countDownContents').bind('keyup change click' ,function(){
            var countDownTime = $(this).val();
            if(countDownTime.match(/[0-9]|\./))
            {
                if(countDownTime<=30 && countDownTime>=1)
                {
                    $('#countDownContents').val(countDownTime);
                }
                if(countDownTime>30)
                {
                    $('#countDownContents').val(30);
                }
                if(countDownTime<=0)
                {
                    $('#countDownContents').val(1);
                }


            }else
            {
                swal({
                    type: 'warning',
                    title: 'Notification',
                    text: 'Countdown time should be numeric and minimum 1 & maximum 30.'
                });
                $('#countDownContents').val(5);
            }
        });
    });

    $(document).ready(function() {

        $("#dashboard-search-btn").on('click',function() {
            console.log('came here : submitting form');
            var data = $("#dashboard-search-form").serialize();
            $("#dashboard-search-form").submit();
        });


        $("#dashboard-search").on('click',function() {
            var tags = $("#dashboard-tags-to-search").tagsinput('items');
            var text = $("#dashboard-text-to-search").val();
            console.log('tags :',tags,' text: ',text);
        });




        $("input[type='checkbox']").on("change", function() {
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

        /*  $('[data-toggle="tooltip"]').tooltip();*/
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


        /* $.fn.modal.Constructor.prototype.enforceFocus = function() {};

         $(".list-group ul li").click(function(){
             $(this).addClass("active");
             $(".list-group ul li").not($(this)).removeClass("active");
             $(window).scrollTop(500);
             var index = $(this).index();
             $("div.tab-content").removeClass("active");
             $("div.tab-content").eq(index).addClass("active");
         });*/
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
@if(session()->has('imgErr'))
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

<script src="{{ URL::to('/').'/public/js/editurl.js' }}"></script>
@if($type == 3)
<script src="{{ URL::to('/').'/public/js/file_link_preview.js' }}"></script>
<script  type="text/javascript">
 $('.cust-msg').text('Edit Custom');
</script>
@endif
</body>
</html>
