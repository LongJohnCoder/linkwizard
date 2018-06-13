<!DOCTYPE html>
<html lang="en">
    <!-- head of the page -->
    @include('contents/head')
    <!-- head end -->
    <body>
        <link rel="stylesheet" href="{{ URL('/')}}/public/css/selectize.legacy.css" />
        <link href="{{ URL::to('/').'/public/css/footer.css'}}" rel="stylesheet" />
        <script src="{{ URL::to('/').'/public/js/selectize.js' }}"></script>
        <script src="{{ URL::to('/').'/public/js/selectize_index.js' }}"></script>
        <script src="{{ URL::to('/').'/public/js/editurl.js' }}"></script>
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.common-material.min.css" />
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.min.css" />
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.mobile.min.css" />
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
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                               
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="normal-box1">
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
                            </div>
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
                                @endif
                            {{csrf_field()}}
                            <button type="submit" id="edit-short-url" class=" btn-shorten">Shorten URL</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
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
<script src="//widget.manychat.com/216100302459827.js" async="async">
</script>

<script src="{{ URL::to('/').'/public/js/fineuploader.min.js' }}"></script>
<link href="{{ URL::to('/').'/public/css/fineuploader-gallery.min.css' }}" rel="stylesheet" />
<link href="{{ URL::to('/').'/public/css/fine-uploader-new.min.css' }}" rel="stylesheet" />
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
        // 		return false;
        // } else {
        // 		return true;
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
    // 		var formData = new FormData(this);
    // 		//console.log('form data :',formData);
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
    // 	x :
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
            var	url_inp			= $("#url_inp").val();
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
    // 				maxItems: null,
    // 				valueField: 'tag',
    // 				labelField: 'tag',
    // 				searchField: 'tag',
    // 				options: [
    // 					{tag: 'tag1'},{tag:'tag2'},{tag:'tag3'}
    // 				],
    // 				create: true
    // 			});

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
        // 	if(thisInstance.checked) {
        // 		$('#fbPixelid1').show();
        // 	} else {
        // 		$('#fbPixelid1').hide();
        // 		$('#fbPixelid1').val('');
        // 	}
        // }

        //google analytics checkbox for short urls
        // if (thisInstance.id === "checkboxAddGlPixelid" && thisInstance["name"] === "chk_gl_short") {
        // 	if(thisInstance.checked) {
        // 		$('#glPixelid').show();
        // 	} else {
        // 		$('#glPixelid').hide();
        // 		$('#glPixelid').val('');
        // 	}
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
