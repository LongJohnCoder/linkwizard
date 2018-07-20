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
<script src="{{ URL::to('/').'/public/js/editurl.js' }}"></script>
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.common-material.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.mobile.min.css" />
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<style type="text/css">
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
                                @else
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2">
                                            <label>Paste An Actual URL Here</label>
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            <input id="givenActual_Url" type="text" name="actual_url[0]" class="form-control " value="<?php echo($urls->actual_url!==NULL) ? $urls->protocol.'://'.$urls->actual_url : ''  ?>" placeholder="Please Provide A Valid Url Like http://www.example.com">
                                            <div class="input-msg">* This is where you paste your long URL that you'd like to shorten.</div>
                                                <div class="row">
                                                    <hr>
                                                    <input type="checkbox" name="customizeOption" id="customizeOption" onchange="valueChanged()"><small>* Check to use the default settings for this url </small>
                                                </div>
                                        </div>

                                        <div class="col-md-2 col-sm-2">

                                        </div>
                                    </div>
                                    <div class="customized-url-div">
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
                                        </div>
                                            <div class="row">
                                                <div class="col-md-2 col-sm-2">
                                                    <label> Select your customise colour </label>
                                                </div>
                                                <div class="col-md-8 col-sm-8">
                                                    <input type="color" name="pageColour" value="{{$urls->customColour}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-sm-2">
                                                    <label> Enter your redirecting text </label>
                                                </div>
                                                <div class="col-md-8 col-sm-8">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="redirecting_text_template" placeholder="Redirecting...">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- OLD PIXEL FRONT END -->
                        <!--<div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Edit facebook pixel
                                    <input type="checkbox" id="checkboxAddFbPixelid" name="checkboxAddFbPixelid" <?php if(count($urls->urlFeature)>0 && $urls->urlFeature->fb_pixel_id!=''){ echo 'checked';}  ?> >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body facebook-pixel" style="display: <?php if(count($urls->urlFeature)>0 && $urls->urlFeature->fb_pixel_id!=''){ echo 'block';}else{ echo 'none';}  ?>" >
                                <p>Paste Your Facebook-pixel-id Here</p>
                                <input type="text" name="fbPixelid" class="form-control" id="fbPixel_id" value="<?php if(count($urls->urlFeature)>0 && $urls->urlFeature->fb_pixel_id!=''){ echo $urls->urlFeature->fb_pixel_id;}else{ echo '';}  ?>" >
                            </div>
                        </div>
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Edit google pixel
                                    <input type="checkbox" id="checkboxAddGlPixelid" name="checkboxAddGlPixelid" <?php if(count($urls->urlFeature)>0 && $urls->urlFeature->gl_pixel_id!=''){ echo 'checked';} ?> >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body google-pixel" style="display: <?php if(count($urls->urlFeature)>0 && $urls->urlFeature->gl_pixel_id!=''){ echo 'block';}else{ echo 'none';}  ?>" >
                                <p>Paste Your Google-pixel-id Here</p>
                                <input type="text" name="glPixelid" class="form-control" id="glPixel_id" value="<?php if(count($urls->urlFeature)>0 && $urls->urlFeature->gl_pixel_id!=''){ echo $urls->urlFeature->gl_pixel_id;}else{ echo '';}  ?>" >
                            </div>
                        </div>-->
                        <!-- END OLD PIXEL FRONT END -->

                        <!-- Pixel manage -->
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Manage pixel
                                    <input type="checkbox" id="managePixel" name="managePixel" <?php echo(count($pixel_name)>0)?'checked':'' ?> >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <input type="hidden" name="pixels" id="pixel-ids">
                            <div class="normal-body pixel-area" style="display: <?php echo(count($pixel_name)>0)?'block':''?>">
                                <p>Add your pixels here</p>
                                <div class="manage_pixel_area" id="manage_pixel_area">
                                    <select class="chosen-select-pixels" data-placeholder="Choose a pixel" multiple tabindex="4" id="manage_pixel_contents" name="pixels[]">
                                        <option value=""></option>
                                        @if(count($pixels)>0 && !empty($pixels))
                                            <optgroup label="Facebook" id="opt-Facebook">
                                                @php
                                                    foreach($pixels as $pxl)
                                                    {
                                                        if(in_array($pxl->id, $pxId) && in_array('Fb_pixel_id', $pixel_name))
                                                        {
                                                            $spanType = 'hasKey';
                                                            break;
                                                        }
                                                        else
                                                        {
                                                            $spanType = 'noKey';
                                                        }
                                                    }
                                                @endphp

                                                @foreach($pixels as $key=>$pixel)
                                                    @if($pixel->network=='fb_pixel_id')
                                                        @if($spanType!=='hasKey')
                                                            @php
                                                                if(in_array($pixel->id, $pxId) && $pixel->network=='fb_pixel_id')
                                                                {
                                                                    $optTypeFB = 'selectDisable';
                                                                    break;
                                                                }
                                                            @endphp
                                                        @else
                                                            <option value="{{$pixel->id}}" data-role="Facebook" disabled>{{$pixel->pixel_name}} - {{$pixel->pixel_id}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach

                                                @if($optTypeFB=='selectDisable' && $spanType!=='hasKey')
                                                    <!-- NO KEY SELECT DISABLE -->
                                                    @foreach($pixels as $px)
                                                            @if($px->network == 'fb_pixel_id')
                                                                <option value="{{$px->id}}" data-role="Facebook" <?php echo(in_array($px->id, $pxId))? 'selected': 'disabled'?> >{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                            @endif
                                                    @endforeach

                                                @elseif($optTypeFB=='normal' && $spanType!=='hasKey')
                                                    <!-- NO KEY ONLY NORMAL -->
                                                    @foreach($pixels as $px)
                                                        @if($px->network == 'fb_pixel_id')
                                                            <option value="{{$px->id}}" data-role="Facebook">{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                            <optgroup label="Google" id="opt-Google">
                                                @php
                                                    foreach($pixels as $pxl)
                                                    {
                                                        if(in_array($pxl->id, $pxId) && in_array('Gl_pixel_id', $pixel_name))
                                                        {
                                                            $spanType = 'hasKey';
                                                            break;
                                                        }
                                                        else
                                                        {
                                                            $spanType = 'noKey';
                                                        }
                                                    }
                                                @endphp

                                                @foreach($pixels as $key=>$pixel)
                                                    @if($pixel->network=='gl_pixel_id')
                                                        @if($spanType!=='hasKey')
                                                            @php
                                                                if(in_array($pixel->id, $pxId) && $pixel->network=='gl_pixel_id')
                                                                {
                                                                    $optTypeGL = 'selectDisable';
                                                                    break;
                                                                }
                                                            @endphp
                                                        @else
                                                            <option value="{{$pixel->id}}" data-role="Google" disabled>{{$pixel->pixel_name}} - {{$pixel->pixel_id}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach

                                                @if($optTypeGL=='selectDisable' && $spanType!=='hasKey')
                                                <!-- NO KEY SELECT DISABLE -->
                                                    @foreach($pixels as $px)
                                                        @if($px->network =='gl_pixel_id')
                                                            <option value="{{$px->id}}" data-role="Google" <?php echo(in_array($px->id, $pxId))? 'selected': 'disabled'?> >{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                        @endif
                                                    @endforeach

                                                @elseif($optTypeGL=='normal' && $spanType!=='hasKey')
                                                <!-- NO KEY ONLY NORMAL -->
                                                    @foreach($pixels as $px)
                                                        @if($px->network =='gl_pixel_id')
                                                            <option value="{{$px->id}}" data-role="Google">{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                            <optgroup label="Twitter" id="opt-Twitter">
                                                @php
                                                    $spanType = 'noKey';
                                                @endphp

                                                @foreach($pixels as $key=>$pixel)
                                                    @if($pixel->network=='twt_pixel_id')
                                                        @if($spanType!=='hasKey')
                                                            @php
                                                                if(in_array($pixel->id, $pxId) && $pixel->network=='twt_pixel_id')
                                                                {
                                                                    $optTypeTWT = 'selectDisable';
                                                                    break;
                                                                }
                                                            @endphp
                                                        @else
                                                            <option value="{{$pixel->id}}" data-role="Twitter" disabled>{{$pixel->pixel_name}} - {{$pixel->pixel_id}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach

                                                @if($optTypeTWT=='selectDisable' && $spanType!=='hasKey')
                                                <!-- NO KEY SELECT DISABLE -->
                                                    @foreach($pixels as $px)
                                                        @if($px->network =='twt_pixel_id')
                                                            <option value="{{$px->id}}" data-role="Twitter" <?php echo(in_array($px->id, $pxId))? 'selected': 'disabled'?> >{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                        @endif
                                                    @endforeach

                                                @elseif($optTypeTWT=='normal' && $spanType!=='hasKey')
                                                <!-- NO KEY ONLY NORMAL -->
                                                    @foreach($pixels as $px)
                                                        @if($px->network =='twt_pixel_id')
                                                            <option value="{{$px->id}}" data-role="Twitter">{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                            <optgroup label="LinkedIn" id="opt-LinkedIn">
                                                @php
                                                    $spanType = 'noKey';
                                                @endphp

                                                @foreach($pixels as $key=>$pixel)
                                                    @if($pixel->network=='li_pixel_id')
                                                        @if($spanType!=='hasKey')
                                                            @php
                                                                if(in_array($pixel->id, $pxId) && $pixel->network=='li_pixel_id')
                                                                {
                                                                    $optTypeLI = 'selectDisable';
                                                                    break;
                                                                }
                                                            @endphp
                                                        @else
                                                            <option value="{{$pixel->id}}" data-role="LinkedIn" disabled>{{$pixel->pixel_name}} - {{$pixel->pixel_id}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach

                                                @if($optTypeLI=='selectDisable' && $spanType!=='hasKey')
                                                <!-- NO KEY SELECT DISABLE -->
                                                    @foreach($pixels as $px)
                                                        @if($px->network =='li_pixel_id')
                                                            <option value="{{$px->id}}" data-role="LinkedIn" <?php echo(in_array($px->id, $pxId))? 'selected': 'disabled'?> >{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                        @endif
                                                    @endforeach

                                                @elseif($optTypeLI=='normal' && $spanType!=='hasKey')
                                                <!-- NO KEY ONLY NORMAL -->
                                                    @foreach($pixels as $px)
                                                        @if($px->network =='li_pixel_id')
                                                            <option value="{{$px->id}}" data-role="LinkedIn">{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                            <optgroup label="Pinterest" id="opt-Pinterest">
                                                @php
                                                    $spanType = 'noKey';
                                                @endphp

                                                @foreach($pixels as $key=>$pixel)
                                                    @if($pixel->network=='pinterest_pixel_id')
                                                        @if($spanType!=='hasKey')
                                                            @php
                                                                if(in_array($pixel->id, $pxId) && $pixel->network=='pinterest_pixel_id')
                                                                {
                                                                    $optTypeLI = 'selectDisable';
                                                                    break;
                                                                }
                                                            @endphp
                                                        @else
                                                            <option value="{{$pixel->id}}" data-role="Pinterest" disabled>{{$pixel->pixel_name}} - {{$pixel->pixel_id}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach

                                                @if($optTypeLI=='selectDisable' && $spanType!=='hasKey')
                                                <!-- NO KEY SELECT DISABLE -->
                                                    @foreach($pixels as $px)
                                                        @if($px->network =='pinterest_pixel_id')
                                                            <option value="{{$px->id}}" data-role="Pinterest" <?php echo(in_array($px->id, $pxId))? 'selected': 'disabled'?> >{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                        @endif
                                                    @endforeach

                                                @elseif($optTypeLI=='normal' && $spanType!=='hasKey')
                                                <!-- NO KEY ONLY NORMAL -->
                                                    @foreach($pixels as $px)
                                                        @if($px->network =='pinterest_pixel_id')
                                                            <option value="{{$px->id}}" data-role="Pinterest">{{$px->pixel_name}} - {{$px->pixel_id}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                            <optgroup label="Custom" id="opt-Custom">
                                                @php
                                                    $spanType = 'noKey';
                                                @endphp

                                                @foreach($pixels as $key=>$pixel)
                                                    @if($pixel->network=='custom_pixel_id')
                                                        @if($spanType!=='hasKey')
                                                            <option value="{{$pixel->id}}" data-role="Custom" <?php echo(in_array($pixel->id, $pxId))? 'selected': ''?> >{{$pixel->pixel_name}}</option>
                                                        @else
                                                            <option value="{{$pixel->id}}" data-role="Custom" disabled>{{$pixel->pixel_name}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Oldpixel" id="opt-Oldpixel">
                                                <!-- validation for old pixels -->

                                                @foreach($pxId as $key=>$pxid)
                                                    @if($pxid==0)
                                                        <option value="0" data-role="Oldpixel-{{strtolower($pixel_name[$key])}}" selected>{{strtoupper(str_replace('_', ' ', $pixel_name[$key]))}}-{{$pixel_id[$key]}}</option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
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
                                <label class="custom-checkbox">Edit count down timer
                                    <input type="checkbox" id="countDownEnable" name="allowCountDown" <?php if($urls->redirecting_time != 5000 ){echo 'checked';}?> >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body add-countDown" id="countDownArea" style="display: <?php if($urls->redirecting_time != 5000){echo 'block';}else{ echo 'none';}?>">
                                <p>Edit countdown time for this link</p>
                                <input type="number" min="1" max="30" id="countDownContents" name="redirecting_time" class = "form-control" value="<?php if($urls->redirecting_time != 5000){echo ($urls->redirecting_time)/1000;}else{ echo 5;}?>" >
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
                                <ul>
                                    <li>
                                        <label class="custom-checkbox">Use Original
                                            <input type="checkbox" id="link_preview_original" name="link_preview_original" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->main==0){echo 'checked'; } }else{echo '';}?> >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="custom-checkbox">Use Custom
                                            <input type="checkbox" id="link_preview_custom" name="link_preview_custom"<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->main==1){echo 'checked'; } }else{echo '';}?> >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                                <div class="use-custom" style="display :<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->main==1){echo 'block'; } }else{echo 'none';}?>">
                                    <div class="white-paneel">
                                        <div class="white-panel-header">Image</div>
                                        <div class="white-panel-body">
                                            <ul>
                                                <li>
                                                    <label class="custom-checkbox">Use Original
                                                        <input type="checkbox" id="org_img_chk" name="org_img_chk" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->image==0){echo 'checked'; } }else{echo '';}?> >
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox">Use Custom
                                                        <input type="checkbox" id="cust_img_chk" name="cust_img_chk" onclick="set_custom_prev_on(this.checked)" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->image==1){echo 'checked'; } }else{echo '';}?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom1 img-inp" style="display:<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->image==1){echo 'block'; } }else{echo 'none';}?>">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="file" class="form-control" id="img_inp" name="img_inp">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->image==1){ ?>
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
                                                <li>
                                                    <label class="custom-checkbox">Use Original
                                                        <input type="checkbox" id="org_title_chk" name="org_title_chk"  <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->title==0){echo 'checked'; } }else{echo '';}?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox">Use Custom
                                                        <input type="checkbox" id="cust_title_chk" name="cust_title_chk" onclick="set_custom_prev_on(this.checked)" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->title==1){echo 'checked'; } }else{echo '';}?> >
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom1 title-inp" style="display:<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->title==1){echo 'block'; } }else{echo 'none';}?>">
                                                <input type="text" class="form-control" id="title_inp" name="title_inp" value="<?php echo $urls->og_title;?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="white-paneel">
                                        <div class="white-panel-header">Description</div>
                                        <div class="white-panel-body">
                                            <ul>
                                                <li>
                                                    <label class="custom-checkbox">Use Original
                                                        <input type="checkbox" id="org_dsc_chk" name="org_dsc_chk"  <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->description==0){echo 'checked'; } }else{echo '';}?> >
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-checkbox">Use Custom
                                                        <input type="checkbox" id="cust_dsc_chk" name="cust_dsc_chk"  onclick="set_custom_prev_on(this.checked)" <?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->description==1){echo 'checked'; } }else{echo '';}?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="use-custom2 dsc-inp" style="display:<?php if(isset($urls->link_preview_type) && ($urls->link_preview_type!="")  ){ $link_preview = json_decode($urls->link_preview_type);if($link_preview->description==1){echo 'block'; } }else{echo 'none';}?>">
                                                <textarea class="form-control" id="dsc_inp" name="dsc_inp"><?php echo trim($urls->og_description);?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($type==0)
                            <div class="normal-box1">
                                <div class="normal-header">
                                    <table class="merge-tab">
                                        <tr>
                                            <td>
                                                <label class="custom-checkbox">Add expiration date for the link
                                                    <input type="checkbox" id="expirationEnable" name="allowExpiration" <?php echo (!empty($urls->date_time) && $urls->is_scheduled == 'n')? 'checked' : '' ?> >
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="custom-checkbox">Add schedules for the link
                                                    <input type="checkbox" id="addSchedule" name="allowSchedule" <?php echo (empty($urls->date_time) && $urls->is_scheduled == 'y')? 'checked' : '' ?> >
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- expiration part html -->
                                <div class="normal-body add-expiration" id="expirationArea" style="display: <?php echo (!empty($urls->date_time) && $urls->is_scheduled == 'n')? 'block' : 'none' ?> ">
                                    <p>Select date &amp; time for this link</p>
                                    <input type="text" name="date_time" id="datepicker" width="100%" value="<?php if(!empty($urls->date_time)){echo $urls->date_time;} ?>">
                                    <p>Select a timezone</p>
                                    <select name="timezone" id="expirationTZ" class="form-control">
                                        <option value="">Please select a timezone</option>
                                        <option value="Pacific/Midway" <?php echo($urls->timezone=="Pacific/Midway")? 'selected' : '' ?> >(GMT-11:00) Midway Island, Samoa</option>
                                        <option value="America/Adak" <?php echo($urls->timezone=="America/Adak")? 'selected' : '' ?> >(GMT-10:00) Hawaii-Aleutian</option>
                                        <option value="Etc/GMT+10" <?php echo($urls->timezone=="Etc/GMT+10")? 'selected' : '' ?> >(GMT-10:00) Hawaii</option>
                                        <option value="Pacific/Marquesas" <?php echo($urls->timezone=="Etc/GMT+10")? 'selected' : '' ?> >(GMT-09:30) Marquesas Islands</option>
                                        <option value="Pacific/Gambier" <?php echo($urls->timezone=="Pacific/Gambier")? 'selected' : '' ?> >(GMT-09:00) Gambier Islands</option>
                                        <option value="America/Anchorage" <?php echo($urls->timezone=="America/Anchorage")? 'selected' : '' ?> >(GMT-09:00) Alaska</option>
                                        <option value="America/Ensenada" <?php echo($urls->timezone=="America/Ensenada")? 'selected' : '' ?> >(GMT-08:00) Tijuana, Baja California</option>
                                        <option value="Etc/GMT+8" <?php echo($urls->timezone=="Etc/GMT+8")? 'selected' : '' ?> >(GMT-08:00) Pitcairn Islands</option>
                                        <option value="America/Los_Angeles" <?php echo($urls->timezone=="America/Los_Angeles")? 'selected' : '' ?> >(GMT-08:00) Pacific Time (US & Canada)</option>
                                        <option value="America/Denver" <?php echo($urls->timezone=="America/Denver")? 'selected' : '' ?> >(GMT-07:00) Mountain Time (US & Canada)</option>
                                        <option value="America/Chihuahua" <?php echo($urls->timezone=="America/Chihuahua")? 'selected' : '' ?> >(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                        <option value="America/Dawson_Creek" <?php echo($urls->timezone=="America/Dawson_Creek")? 'selected' : '' ?> >(GMT-07:00) Arizona</option>
                                        <option value="America/Belize" <?php echo($urls->timezone=="America/Belize")? 'selected' : '' ?> >(GMT-06:00) Saskatchewan, Central America</option>
                                        <option value="America/Cancun" <?php echo($urls->timezone=="America/Cancun")? 'selected' : '' ?> >(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                        <option value="Chile/EasterIsland" <?php echo($urls->timezone=="Chile/EasterIsland")? 'selected' : '' ?> >(GMT-06:00) Easter Island</option>
                                        <option value="America/Chicago" <?php echo($urls->timezone=="America/Chicago")? 'selected' : '' ?> >(GMT-06:00) Central Time (US & Canada)</option>
                                        <option value="America/New_York" <?php echo($urls->timezone=="America/New_York")? 'selected' : '' ?> >(GMT-05:00) Eastern Time (US & Canada)</option>
                                        <option value="America/Havana" <?php echo($urls->timezone=="America/Havana")? 'selected' : '' ?> >(GMT-05:00) Cuba</option>
                                        <option value="America/Bogota" <?php echo($urls->timezone=="America/Bogota")? 'selected' : '' ?> >(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                        <option value="America/Caracas" <?php echo($urls->timezone=="America/Caracas")? 'selected' : '' ?> >(GMT-04:30) Caracas</option>
                                        <option value="America/Santiago" <?php echo($urls->timezone=="America/Santiago")? 'selected' : '' ?> >(GMT-04:00) Santiago</option>
                                        <option value="America/La_Paz" <?php echo($urls->timezone=="America/La_Paz")? 'selected' : '' ?> >(GMT-04:00) La Paz</option>
                                        <option value="Atlantic/Stanley" <?php echo($urls->timezone=="Atlantic/Stanley")? 'selected' : '' ?> >(GMT-04:00) Faukland Islands</option>
                                        <option value="America/Campo_Grande" <?php echo($urls->timezone=="America/Campo_Grande")? 'selected' : '' ?> >(GMT-04:00) Brazil</option>
                                        <option value="America/Goose_Bay" <?php echo($urls->timezone=="America/Goose_Bay")? 'selected' : '' ?> >(GMT-04:00) Atlantic Time (Goose Bay)</option>
                                        <option value="America/Glace_Bay" <?php echo($urls->timezone=="America/Glace_Bay")? 'selected' : '' ?> >(GMT-04:00) Atlantic Time (Canada)</option>
                                        <option value="America/St_Johns" <?php echo($urls->timezone=="America/St_Johns")? 'selected' : '' ?> >(GMT-03:30) Newfoundland</option>
                                        <option value="America/Araguaina" <?php echo($urls->timezone=="America/Araguaina")? 'selected' : '' ?> >(GMT-03:00) UTC-3</option>
                                        <option value="America/Montevideo" <?php echo($urls->timezone=="America/Montevideo")? 'selected' : '' ?> >(GMT-03:00) Montevideo</option>
                                        <option value="America/Miquelon" <?php echo($urls->timezone=="America/Miquelon")? 'selected' : '' ?> >(GMT-03:00) Miquelon, St. Pierre</option>
                                        <option value="America/Godthab" <?php echo($urls->timezone=="America/Godthab")? 'selected' : '' ?> >(GMT-03:00) Greenland</option>
                                        <option value="America/Argentina/Buenos_Aires" <?php echo($urls->timezone=="America/Argentina/Buenos_Aires")? 'selected' : '' ?> >(GMT-03:00) Buenos Aires</option>
                                        <option value="America/Sao_Paulo" <?php echo($urls->timezone=="America/Sao_Paulo")? 'selected' : '' ?> >(GMT-03:00) Brasilia</option>
                                        <option value="America/Noronha" <?php echo($urls->timezone=="America/Noronha")? 'selected' : '' ?> >(GMT-02:00) Mid-Atlantic</option>
                                        <option value="Atlantic/Cape_Verde" <?php echo($urls->timezone=="Atlantic/Cape_Verde")? 'selected' : '' ?> >(GMT-01:00) Cape Verde Is.</option>
                                        <option value="Atlantic/Azores" <?php echo($urls->timezone=="Atlantic/Azores")? 'selected' : '' ?> >(GMT-01:00) Azores</option>
                                        <option value="Europe/Belfast" <?php echo($urls->timezone=="Europe/Belfast")? 'selected' : '' ?> >(GMT) Greenwich Mean Time : Belfast</option>
                                        <option value="Europe/Dublin" <?php echo($urls->timezone=="Europe/Dublin")? 'selected' : '' ?> >(GMT) Greenwich Mean Time : Dublin</option>
                                        <option value="Europe/Lisbon" <?php echo($urls->timezone=="Europe/Lisbon")? 'selected' : '' ?> >(GMT) Greenwich Mean Time : Lisbon</option>
                                        <option value="Europe/London" <?php echo($urls->timezone=="Europe/London")? 'selected' : '' ?> >(GMT) Greenwich Mean Time : London</option>
                                        <option value="Africa/Abidjan" <?php echo($urls->timezone=="Africa/Abidjan")? 'selected' : '' ?> >(GMT) Monrovia, Reykjavik</option>
                                        <option value="Europe/Amsterdam" <?php echo($urls->timezone=="Europe/Amsterdam")? 'selected' : '' ?> >(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                        <option value="Europe/Belgrade" <?php echo($urls->timezone=="Europe/Belgrade")? 'selected' : '' ?> >(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                        <option value="Europe/Brussels" <?php echo($urls->timezone=="Europe/Brussels")? 'selected' : '' ?> >(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                        <option value="Africa/Algiers" <?php echo($urls->timezone=="Africa/Algiers")? 'selected' : '' ?> >(GMT+01:00) West Central Africa</option>
                                        <option value="Africa/Windhoek" <?php echo($urls->timezone=="Africa/Windhoek")? 'selected' : '' ?> >(GMT+01:00) Windhoek</option>
                                        <option value="Asia/Beirut" <?php echo($urls->timezone=="Asia/Beirut")? 'selected' : '' ?> >(GMT+02:00) Beirut</option>
                                        <option value="Africa/Cairo" <?php echo($urls->timezone=="Africa/Cairo")? 'selected' : '' ?> >(GMT+02:00) Cairo</option>
                                        <option value="Asia/Gaza" <?php echo($urls->timezone=="Asia/Gaza")? 'selected' : '' ?> >(GMT+02:00) Gaza</option>
                                        <option value="Africa/Blantyre" <?php echo($urls->timezone=="Africa/Blantyre")? 'selected' : '' ?> >(GMT+02:00) Harare, Pretoria</option>
                                        <option value="Asia/Jerusalem" <?php echo($urls->timezone=="Asia/Jerusalem")? 'selected' : '' ?> >(GMT+02:00) Jerusalem</option>
                                        <option value="Europe/Minsk" <?php echo($urls->timezone=="Europe/Minsk")? 'selected' : '' ?> >(GMT+02:00) Minsk</option>
                                        <option value="Asia/Damascus" <?php echo($urls->timezone=="Asia/Damascus")? 'selected' : '' ?> >(GMT+02:00) Syria</option>
                                        <option value="Europe/Moscow" <?php echo($urls->timezone=="Europe/Moscow")? 'selected' : '' ?> >(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                        <option value="Africa/Addis_Ababa" <?php echo($urls->timezone=="Africa/Addis_Ababa")? 'selected' : '' ?> >(GMT+03:00) Nairobi</option>
                                        <option value="Asia/Tehran" <?php echo($urls->timezone=="Asia/Tehran")? 'selected' : '' ?> >(GMT+03:30) Tehran</option>
                                        <option value="Asia/Dubai" <?php echo($urls->timezone=="Asia/Dubai")? 'selected' : '' ?> >(GMT+04:00) Abu Dhabi, Muscat</option>
                                        <option value="Asia/Yerevan" <?php echo($urls->timezone=="Asia/Yerevan")? 'selected' : '' ?> >(GMT+04:00) Yerevan</option>
                                        <option value="Asia/Kabul" <?php echo($urls->timezone=="Asia/Kabul")? 'selected' : '' ?> >(GMT+04:30) Kabul</option>
                                        <option value="Asia/Yekaterinburg" <?php echo($urls->timezone=="Asia/Yekaterinburg")? 'selected' : '' ?> >(GMT+05:00) Ekaterinburg</option>
                                        <option value="Asia/Tashkent" <?php echo($urls->timezone=="Asia/Tashkent")? 'selected' : '' ?> >(GMT+05:00) Tashkent</option>
                                        <option value="Asia/Kolkata" <?php echo($urls->timezone=="Asia/Kolkata")? 'selected' : '' ?> >(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                        <option value="Asia/Katmandu" <?php echo($urls->timezone=="Asia/Katmandu")? 'selected' : '' ?> >(GMT+05:45) Kathmandu</option>
                                        <option value="Asia/Dhaka" <?php echo($urls->timezone=="Asia/Dhaka")? 'selected' : '' ?> >(GMT+06:00) Astana, Dhaka</option>
                                        <option value="Asia/Novosibirsk" <?php echo($urls->timezone=="Asia/Novosibirsk")? 'selected' : '' ?> >(GMT+06:00) Novosibirsk</option>
                                        <option value="Asia/Rangoon" <?php echo($urls->timezone=="Asia/Rangoon")? 'selected' : '' ?> >(GMT+06:30) Yangon (Rangoon)</option>
                                        <option value="Asia/Bangkok" <?php echo($urls->timezone=="Asia/Bangkok")? 'selected' : '' ?> >(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                        <option value="Asia/Krasnoyarsk" <?php echo($urls->timezone=="Asia/Krasnoyarsk")? 'selected' : '' ?> >(GMT+07:00) Krasnoyarsk</option>
                                        <option value="Asia/Hong_Kong" <?php echo($urls->timezone=="Asia/Hong_Kong")? 'selected' : '' ?> >(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                        <option value="Asia/Irkutsk" <?php echo($urls->timezone=="Asia/Irkutsk")? 'selected' : '' ?> >(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                        <option value="Australia/Perth" <?php echo($urls->timezone=="Australia/Perth")? 'selected' : '' ?> >(GMT+08:00) Perth</option>
                                        <option value="Australia/Eucla" <?php echo($urls->timezone=="Australia/Eucla")? 'selected' : '' ?> >(GMT+08:45) Eucla</option>
                                        <option value="Asia/Tokyo" <?php echo($urls->timezone=="Asia/Tokyo")? 'selected' : '' ?> >(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                        <option value="Asia/Seoul" <?php echo($urls->timezone=="Asia/Seoul")? 'selected' : '' ?> >(GMT+09:00) Seoul</option>
                                        <option value="Asia/Yakutsk" <?php echo($urls->timezone=="Asia/Yakutsk")? 'selected' : '' ?> >(GMT+09:00) Yakutsk</option>
                                        <option value="Australia/Adelaide" <?php echo($urls->timezone=="Australia/Adelaide")? 'selected' : '' ?> >(GMT+09:30) Adelaide</option>
                                        <option value="Australia/Darwin" <?php echo($urls->timezone=="Australia/Darwin")? 'selected' : '' ?> >(GMT+09:30) Darwin</option>
                                        <option value="Australia/Brisbane" <?php echo($urls->timezone=="Australia/Brisbane")? 'selected' : '' ?> >(GMT+10:00) Brisbane</option>
                                        <option value="Australia/Hobart" <?php echo($urls->timezone=="Australia/Hobart")? 'selected' : '' ?> >(GMT+10:00) Hobart</option>
                                        <option value="Asia/Vladivostok" <?php echo($urls->timezone=="Asia/Vladivostok")? 'selected' : '' ?> >(GMT+10:00) Vladivostok</option>
                                        <option value="Australia/Lord_Howe" <?php echo($urls->timezone=="Australia/Lord_Howe")? 'selected' : '' ?> >(GMT+10:30) Lord Howe Island</option>
                                        <option value="Etc/GMT-11" <?php echo($urls->timezone=="Etc/GMT-11")? 'selected' : '' ?> >(GMT+11:00) Solomon Is., New Caledonia</option>
                                        <option value="Asia/Magadan" <?php echo($urls->timezone=="Asia/Magadan")? 'selected' : '' ?> >(GMT+11:00) Magadan</option>
                                        <option value="Pacific/Norfolk" <?php echo($urls->timezone=="Pacific/Norfolk")? 'selected' : '' ?> >(GMT+11:30) Norfolk Island</option>
                                        <option value="Asia/Anadyr" <?php echo($urls->timezone=="Asia/Anadyr")? 'selected' : '' ?> >(GMT+12:00) Anadyr, Kamchatka</option>
                                        <option value="Pacific/Auckland" <?php echo($urls->timezone=="Pacific/Auckland")? 'selected' : '' ?> >(GMT+12:00) Auckland, Wellington</option>
                                        <option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                        <option value="Pacific/Chatham" <?php echo($urls->timezone=="Pacific/Chatham")? 'selected' : '' ?> >(GMT+12:45) Chatham Islands</option>
                                        <option value="Pacific/Tongatapu" <?php echo($urls->timezone=="Pacific/Tongatapu")? 'selected' : '' ?> >(GMT+13:00) Nuku'alofa</option>
                                        <option value="Pacific/Kiritimati" <?php echo($urls->timezone=="Pacific/Kiritimati")? 'selected' : '' ?> >(GMT+14:00) Kiritimati</option>
                                    </select>
                                    <p>Select a redirection page url after expiration</p>
                                    <input type="text" class="form-control" name="redirect_url" id="expirationUrl" value="<?php echo(!empty($urls->redirect_url))? $urls->redirect_url : '' ?>" onchange="checkUrl(this.value)">
                                </div>
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
                            </div>
                            <!--Box For Adding Geo Location-->
                            <div class="normal-box1">
                                <div class="normal-header">
                                    <label class="custom-checkbox">Edit Geo Location
                                        <input type="checkbox" id="editGeoLocation" name="editGeoLocation" <?php if(isset($urls->geolocation)){echo 'checked';}?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
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
                                            Deny All
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
                        <button type="submit" id="edit-short-url" class=" btn-shorten">Shorten URL</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="allow-country-modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
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
                            <div class="col-md-4 col-lg-4">
                                <h4> Allow </h4>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <input type="checkbox" name="allow-redirect-url-checkbox" id="allow-redirect-url-checkbox" style="height: 30px;">
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <h4> Redirect </h4>
                            </div>
                            <div class="col-md-12 col-lg-12 form-group">
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
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row" id="deny-block">
                            <div class="col-md-6 col-lg-6">
                                <h4 id="denied-country-name" style="text-align: center;"></h4>
                                <input type="hidden" name="deny-country-code" id="deny-country-code" value="">
                                <input type="hidden" name="deny-country-id" id="deny-country-id" value="">
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <input type="checkbox" name="deny-country" id="deny-country" style="height: 30px;">
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <h4> Block </h4>
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
 // $(document).ready(function(){
 //     $('.chosen-choices li').each(function(){
 //         var li = $(this).find('span')
 //         console.log('span- '+li.text());
 //     });
 // });
</script>
<script type="text/javascript">
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
                if($(this).val()==selected_value)
                {
                    var label = $(this).data('role');
                    labelArr.push(label);
                }
            });
            var optLabel = labelArr[0];
            //alert(optLabel);
            //$('#opt-'+optLabel).prop('disabled', 'disabled').trigger("chosen:updated");
            $('#opt-'+optLabel).find('option').each(function(){
                if($(this).val()!=selected_value)
                {
                    $(this).prop('disabled', 'disabled').trigger("chosen:updated");
                }
            });

            /**/

            var pixels = $('#pixel-ids').val();
            if(pixels.length==0)
            {
                $('#pixel-ids').val(el.selected);
            }
            else
            {
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

                    if(indx==remIndex)
                    {
                        var remLabel = $(this).data('role');
                        var remVal = $(this).val();
                        if(remVal!='0')
                        {
                            remArr.push(remLabel);
                            remValArr.push(remVal);
                            var remOptlabel = remArr[0];

                            $('#opt-'+remOptlabel).find('option').each(function(){
                                if($(this).val()!=remValArr[0])
                                {
                                    $(this).prop('disabled', false).trigger("chosen:updated");
                                }
                            });
                        }
                        else if(remVal=='0')
                        {
                            $(this).prop('disabled', true).trigger("chosen:updated");
                            remLabel = remLabel.replace('Oldpixel-', '').trim();
                            if(remLabel=='fb_pixel_id')
                            {
                                $('#opt-Facebook').find('option').each(function(){
                                    $(this).removeAttr('disabled').trigger("chosen:updated");
                                })
                            }
                            else if(remLabel=='gl_pixel_id')
                            {
                                $('#opt-Google').find('option').each(function(){
                                    $(this).removeAttr('disabled').trigger("chosen:updated");
                                })
                            }
                        }
                    }

                });

            });

            // end of removing pixel validation for onchange chosen
        });

        /* end of pixel manage */
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

                if(indx==remIndex)
                {
                    var remLabel = $(this).data('role');
                    var remVal = $(this).val();
                    if(remVal!='0')
                    {
                        remArr.push(remLabel);
                        remValArr.push(remVal);
                        var remOptlabel = remArr[0];

                        $('#opt-'+remOptlabel).find('option').each(function(){
                            if($(this).val()!=remValArr[0])
                            {
                                $(this).prop('disabled', false).trigger("chosen:updated");
                                $(document).trigger('readyAgain');
                            }
                        });
                    }
                    else if(remVal=='0')
                    {
                        $(this).prop('disabled', true).trigger("chosen:updated");
                        remLabel = remLabel.replace('Oldpixel-', '').trim();
                        if(remLabel=='fb_pixel_id')
                        {
                            $('#opt-Facebook').find('option').each(function(){
                                $(this).removeAttr('disabled').trigger("chosen:updated");
                            })
                        }
                        else if(remLabel=='gl_pixel_id')
                        {
                            $('#opt-Google').find('option').each(function(){
                                $(this).removeAttr('disabled').trigger("chosen:updated");
                            })
                        }
                    }
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

        //Add Manage Pixel
        if(thisInstance.id=="managePixel")
        {
            if(thisInstance.checked)
            {
                $('.pixel-area').show();
                $('#manage_pixel_area').show();
            }
            else
            {
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


<script type="text/javascript">
    $(document).ready(function(){
            $('#customizeOption').click(function(){
                $('.customized-url-div').toggle();
            });
        /*
                if (typeof(FB) != 'undefined'
                    && FB != null ) {
                    // run the app
                } else {
                    alert('check browser settings to enable facebook sharing.. ');
                }*/
    });
</script>
</body>
</html>