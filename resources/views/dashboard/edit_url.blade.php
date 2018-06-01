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
        <!-- Kendo date time picker -->
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.common-material.min.css" />
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.min.css" />
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.mobile.min.css" />

        <script src="https://kendo.cdn.telerik.com/2018.2.516/js/jquery.min.js"></script>
        <script src="https://kendo.cdn.telerik.com/2018.2.516/js/kendo.all.min.js"></script>

        <!-- gijgo datetime picker -->
        <script src="https://cdn.rawgit.com/atatanasov/gijgo/master/dist/combined/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://cdn.rawgit.com/atatanasov/gijgo/master/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />

        <!-- BOOTSTRAP DATE TIME PICKER -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        
        <!-- Header Start -->
        @include('contents/header')
        <!-- Header End -->
        <div class="main-dashboard-body">
            <section class="main-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <form id="url_short_frm" action="{{route('edit_short_url', $urls->id)}}" method="POST" enctype="multipart/form-data" files=true>
                            <input type="hidden" value="{{$type}}" name="type">
                            <input type="hidden" value="logedin" name="loggedin">
                            <div class="normal-box ">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <label>Paste An Actual URL Here</label>
                                    </div>
                                    <div class="col-md-9 col-sm-9">
                                        <input id="givenActual_Url" type="text" name="actual_url" class="form-control long-url" value="{{$urls->protocol}}://{{$urls->actual_url}}">
                                        <div class="input-msg">* This is where you paste your long URL that you'd like to shorten.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if(strtolower($type) == 'custom')
                                        <div class="col-md-3 col-sm-3">
                                            <label>Paste Your Customized Url Name</label>
                                        </div>
                                        <div class="col-md-9 col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-addon">{{config('settings.APP_REDIRECT_HOST')}}/</span>
                                                <input id="makeCustom_Url" type="text" name="custom_url" class="form-control long-url">
                                            </div>
                                            <div class="input-msg">*Required</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="normal-box1">
                                <div class="normal-header">
                                    <label class="custom-checkbox">Edit facebook pixel
                                        <input type="checkbox" id="checkboxAddFbPixelid" name="checkboxAddFbPixelid" <?php if(count($urls->urlFeature)>0 && $urls->urlFeature->fb_pixel_id!=''){ echo 'checked';}else{ echo 'none';}  ?> >
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
                                        <input type="checkbox" id="checkboxAddGlPixelid" name="checkboxAddGlPixelid" <?php if(count($urls->urlFeature)>0 && $urls->urlFeature->gl_pixel_id!=''){ echo 'checked';}else{ echo 'none';}  ?> >
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
                                        <input type="checkbox" id="shortTagsEnable" name="allowTag" <?php if(count($urls->urlTagMap)>0){echo 'checked';}else{echo '';}?> >
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
                                        <input type="checkbox" id="descriptionEnable" name="allowDescription" <?php if(!empty($urls->meta_description)){echo 'checked';}?> >
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="normal-body add-description" id="descriptionArea" style="display: <?php if(!empty($urls->meta_description)){echo 'block';}else{ echo 'none';}?>">
                                    <p>Mention description for this link</p>
                                    <textarea id="descriptionContents" name="searchDescription" class = "form-control"><?php if(!empty($urls->meta_description)){echo $urls->meta_description;}else{ echo '';}?></textarea>
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
                                    <label class="custom-checkbox">Link Preview
                                        <input type="checkbox" id="link_preview_selector" name="link_preview_selector" <?php if($urls->is_custom==1){echo 'checked';}else{echo '';}?> >
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="normal-body link-preview" style="display: <?php if($urls->is_custom==1){echo 'block';}else{echo 'none';}?>;">
                                    <ul>
                                        <li>
                                            <label class="custom-checkbox">Use Original
                                                <input type="checkbox" id="link_preview_original" name="link_preview_original" <?php if($urls->is_custom==0){echo 'checked';}else{echo '';}?> >
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom-checkbox">Use Custom
                                                <input type="checkbox" id="link_preview_custom" name="link_preview_custom" <?php if($urls->is_custom==1){echo 'checked';}else{echo '';}?> >
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="use-custom" style="display: block;">
                                        <div class="white-paneel">
                                            <div class="white-panel-header">Image</div>
                                            <div class="white-panel-body">
                                                <ul>
                                                    <li>
                                                        <label class="custom-checkbox">Use Original
                                                            <input type="checkbox" id="org_img_chk" name="org_img_chk" <?php if($urls->is_custom==0){echo 'checked';}else{echo '';}?> >
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-checkbox">Use Custom
                                                            <input type="checkbox" id="cust_img_chk" name="cust_img_chk" <?php if($urls->is_custom==1){echo 'checked';}else{echo '';}?> onclick="set_custom_prev_on(this.checked)" >
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                                <div class="use-custom1 img-inp" style="display: <?php if($urls->is_custom==1){echo 'block';}else{echo 'none';}?>">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <input type="file" class="form-control" id="img_inp" name="img_inp">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <?php
                                                                if($urls->is_custom==1){
                                                            ?>
                                                                <img src="{{$urls->og_image}}" class="img-responsive" style="width: 100px;">
                                                            <?php
                                                                }
                                                            ?>
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
                                                            <input type="checkbox" id="org_title_chk" name="org_title_chk" <?php if($urls->is_custom==0){echo 'checked';}else{echo '';}?> >
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-checkbox">Use Custom
                                                            <input type="checkbox" id="cust_title_chk" name="cust_title_chk" <?php if($urls->is_custom==1){echo 'checked';}else{echo '';}?> onclick="set_custom_prev_on(this.checked)" >
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                                <div class="use-custom1 title-inp" style="display: <?php if($urls->is_custom==1){echo 'block';}else{echo 'none';}?>" >
                                                    <input type="text" class="form-control" id="title_inp" name="title_inp" value="<?php if($urls->is_custom==1){echo $urls->og_title;}else{echo '';}?>" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="white-paneel">
                                            <div class="white-panel-header">Description</div>
                                            <div class="white-panel-body">
                                                <ul>
                                                    <li>
                                                        <label class="custom-checkbox">Use Original
                                                            <input type="checkbox" id="org_dsc_chk" name="org_dsc_chk" <?php if($urls->is_custom==0){echo 'checked';}else{echo '';}?> >
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-checkbox">Use Custom
                                                            <input type="checkbox" id="cust_dsc_chk" name="cust_dsc_chk" <?php if($urls->is_custom==1){echo 'checked';}else{echo '';}?> onclick="set_custom_prev_on(this.checked)" >
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                                <div class="use-custom2 dsc-inp" style="display: <?php if($urls->is_custom==1){echo 'block';}else{echo 'none';}?>" >
                                                    <textarea class="form-control" id="dsc_inp" name="dsc_inp">
                                                        <?php if($urls->is_custom==1){echo trim($urls->og_description);}else{echo '';}?>
                                                    </textarea>
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
                                                        <label class="custom-checkbox">Use Custom
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
                           
                            <!--{{--<div class="normal-box1">
                                <div class="normal-header">
                                    <label class="custom-checkbox">Edit Link Expiration 
                                        <input type="checkbox" id="expirationEnable" name="allowExpiration" <?php if(!empty($urls->date_time)){echo 'checked';}?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="normal-body add-expiration" id="expirationArea" style="<?php if(!empty($urls->date_time)){echo 'display: block';}?>">
                                    <p>Select date &amp; time for this link</p>
                                    <input id="datepicker" class="datepicker" name="date_time" value="<?php if(!empty($urls->date_time)){echo $urls->date_time;} ?>"/>
 
                                    <p>Select a timezone</p>

                                    <select name="timezone" id="expirationTZ">
                                        <option value="">Please select a timezone</option>
                                        <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
                                        <option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
                                        <option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
                                        <option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
                                        <option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
                                        <option value="America/Anchorage">(GMT-09:00) Alaska</option>
                                        <option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
                                        <option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
                                        <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
                                        <option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
                                        <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                        <option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
                                        <option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
                                        <option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                        <option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
                                        <option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
                                        <option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
                                        <option value="America/Havana">(GMT-05:00) Cuba</option>
                                        <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                        <option value="America/Caracas">(GMT-04:30) Caracas</option>
                                        <option value="America/Santiago">(GMT-04:00) Santiago</option>
                                        <option value="America/La_Paz">(GMT-04:00) La Paz</option>
                                        <option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
                                        <option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
                                        <option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
                                        <option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
                                        <option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
                                        <option value="America/Araguaina">(GMT-03:00) UTC-3</option>
                                        <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
                                        <option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
                                        <option value="America/Godthab">(GMT-03:00) Greenland</option>
                                        <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
                                        <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                                        <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                                        <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                                        <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
                                        <option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
                                        <option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
                                        <option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
                                        <option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
                                        <option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
                                        <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                        <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                        <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                        <option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
                                        <option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
                                        <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
                                        <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
                                        <option value="Asia/Gaza">(GMT+02:00) Gaza</option>
                                        <option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
                                        <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                                        <option value="Europe/Minsk">(GMT+02:00) Minsk</option>
                                        <option value="Asia/Damascus">(GMT+02:00) Syria</option>
                                        <option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                        <option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
                                        <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
                                        <option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
                                        <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                                        <option value="Asia/Kabul">(GMT+04:30) Kabul</option>
                                        <option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
                                        <option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
                                        <option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                        <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                                        <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                                        <option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
                                        <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                                        <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                        <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                                        <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                        <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                        <option value="Australia/Perth">(GMT+08:00) Perth</option>
                                        <option value="Australia/Eucla">(GMT+08:45) Eucla</option>
                                        <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                        <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
                                        <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
                                        <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                                        <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
                                        <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
                                        <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
                                        <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                                        <option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
                                        <option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
                                        <option value="Asia/Magadan">(GMT+11:00) Magadan</option>
                                        <option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
                                        <option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
                                        <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
                                        <option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                        <option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
                                        <option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
                                        <option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
                                    </select>
                                    <p>Select a redirection page url after expiration</p>
                                    <input type="text" class="form-control" name="redirect_url" id="expirationUrl" value="{{$urls->redirect_url}}">
                                </div>
                            </div> --}}-->

                            {{--Link Schedule--}}

                            {{--<div class="normal-box1">--}}
                                {{--<div class="normal-header">--}}
                                    {{--<label class="custom-checkbox">Add Schedules for the link--}}
                                        {{--<input type="checkbox" id="addSchedule" name="allowSchedule">--}}
                                        {{--<span class="checkmark"></span>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="" id="scheduleArea">--}}
                                    {{--<div id="day-1">--}}
                                        {{--<h5 class="text-muted text-center">Link For Monday</h5>--}}
                                        {{--<input type="text" class="form-control" name="day1" id="day1" placeholder="Link for monday">--}}
                                    {{--</div>--}}
                                    {{--<div id="day-2" class="schedule-day">--}}
                                        {{--<h5 class="text-muted text-center">Link For Tuesday</h5>--}}
                                        {{--<input type="text" class="form-control" name="day2" id="day2" placeholder="Link for tuesday">--}}
                                    {{--</div>--}}
                                    {{--<div id="day-3" class="schedule-day">--}}
                                        {{--<h5 class="text-muted text-center">Link For Wednesday</h5>--}}
                                        {{--<input type="text" class="form-control" name="day2" id="day3" placeholder="Link for wednesday">--}}
                                    {{--</div>--}}

                                    {{--<div id="day-4" class="schedule-day">--}}
                                        {{--<h5 class="text-muted text-center">Link For Thursday</h5>--}}
                                        {{--<input type="text" class="form-control" name="day4" id="day4" placeholder="Link for thursday">--}}
                                    {{--</div>--}}

                                    {{--<div id="day-5" class="schedule-day">--}}
                                        {{--<h5 class="text-muted text-center">Link For Friday</h5>--}}
                                        {{--<input type="text" class="form-control" name="day5" id="day5" placeholder="Link for friday">--}}
                                    {{--</div>--}}

                                    {{--<div id="day-6" class="schedule-day">--}}
                                        {{--<h5 class="text-muted text-center">Link For Saturday</h5>--}}
                                        {{--<input type="text" class="form-control" name="day6" id="day6" placeholder="Link for saturday">--}}
                                    {{--</div>--}}

                                    {{--<div id="day-7" class="schedule-day">--}}
                                        {{--<h5 class="text-muted text-center">Link For Sunday</h5>--}}
                                        {{--<input type="text" class="form-control" name="day7" id="day7" placeholder="Link for sunday">--}}
                                    {{--</div>--}}

                                    {{--<button class="btn btn-sm btn-default">Previous</button>--}}
                                    {{--<button class="btn btn-sm btn-success">Next</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{csrf_field()}}
                            <button type="button" id="shorten_url_btn" class=" btn-shorten">Shorten URL</button>
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
    $("#shortTags_Contents").chosen(
        {no_results_text: "No result found. Press enter to add "}
    );
    var selectedTags = [];
    @if(count($urlTags)>0)
        @foreach($urlTags as $tags )
           selectedTags.push('{{$tags}}');
        @endforeach
    @endif
    $('#shortTags_Contents').val(selectedTags).trigger('chosen:updated');

    $(".chosen-container").bind('keyup',function(e) {
        if (e.which == 13 || e.which == 188){
            var lastChar = e.target.value.slice(-1);
            var strVal  = e.target.value;
            strVal = strVal.trim();
            if(strVal.length == 0) return false;
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

    var shortenUrlFunc = function() {
        var urlToHit = @if($type == 'short') "{{ route('postShortUrlTier5') }}" @elseif($type == 'custom')  "{{ route('postCustomUrlTier5') }}" @endif;

        var actualUrl = $('#givenActual_Url').val();

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

        var customUrl = null;
        @if($type == 'custom')
            customUrl = $('#makeCustom_Url').val();
        @endif
        $("#url_short_frm").submit();
    }



    $("#shorten_url_btn").on('click',function(e){

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
        if($('#expirationEnable').prop('checked'))
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
    });

    var appURL = "{{url('/')}}";
    appURL = appURL.replace('https://','');
    appURL = appURL.replace('http://','');


    window.onload = function(){
        console.log('reached here');
        //giveMyTags();
    }

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

        if (thisInstance.id === "expirationEnable") {
            if(thisInstance.checked) {
                $('#expirationArea').show();
                //$('#descriptionContents').show();
                $('#datepicker').prop('required', true);
                //$('#expirationTZ').prop('required', true);
            } else {
                $('#datepicker').val('');
                $('#expirationTZ').val('');
                $('#expirationUrl').val('');
                $('#expirationArea').hide();

                $('#datepicker').prop('required', false);
                $('#expirationTZ').prop('required', false);
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
