<!DOCTYPE html>
<html lang="en">

    <!-- head start -->
    @include('contents/head')
    <!-- head end -->
    <body>
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
                                                <label> Paste An Actual URL Here </label>
                                            </div>
                                            <div class="col-md-8 col-sm-8">
                                                <div class="form-group">
                                                    <input id="givenActual_Url_0" type="text" name="actual_url[0]" class="form-control actual-url" placeholder="Please Provide A Valid Url Like http://www.example.com">
                                                </div>
                                                <div class="input-msg form-group">
                                                    * This is where you paste your long URL that you'd like to shorten.
                                                </div>
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
                                        <div class="row" id="customized-url-div">
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
                                        <div class="row" id="error-custom-url">
                                        </div>
                                    @endif 
                                    @endif 
                                </div>
                                <!--Add URL End-->
                                <!--Add facebook pixel Start-->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add facebook pixel
                                            <input type="checkbox" id="checkboxAddFbPixelid" name="checkboxAddFbPixelid">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body facebook-pixel">
                                        <p>Paste Your Facebook-pixel-id Here</p>
                                        <input type="text" name="fbPixelid" class="form-control" id="fbPixel_id">
                                    </div>
                                </div>
                                <!--Add facebook pixel End-->
                                <!--Add google pixel Start-->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add google pixel
                                            <input type="checkbox" id="checkboxAddGlPixelid" name="checkboxAddGlPixelid">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body google-pixel">
                                        <p>Paste Your Google-pixel-id Here</p>
                                        <input type="text" name="glPixelid" class="form-control" id="glPixel_id">
                                    </div>
                                </div>
                                <!--Add google pixel End-->

                                <!-- Pixel manage -->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Manage pixel
                                            <input type="checkbox" id="managePixel" name="managePixel">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body pixel-area">
                                        <p>Add your pixels here</p>
                                        <div class="manage_pixel_area" id="manage_pixel_area">
                                            <select class="chosen-select-pixels" data-placeholder="Choose a pixel" multiple tabindex="4" id="manage_pixel_contents" name="pixels[]">
                                                <option value=""></option>
                                                @if(count($pixels)>0 && !empty($pixels))
                                                    @foreach($pixels as $key=>$pixel)
                                                        <option value="{{$pixel->id}}">{{$pixel->pixel_name}} - {{$pixel->pixel_id}}</option>
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
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add count down timer
                                            <input type="checkbox" id="countDownEnable" name="allowCountDown">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body add-countDown" id="countDownArea">
                                        <p>Add countdown time for this link</p>
                                        <input type="number" min="1" max="30" id="countDownContents" name="redirecting_time" class = "form-control" value="5">
                                    </div>
                                </div>
                                <!--Add Link Preview Start-->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Link Preview
                                            <input type="checkbox" id="link_preview_selector" name="link_preview_selector">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="normal-body link-preview">
                                        <ul>
                                            <li>
                                                <label class="custom-checkbox">Use Original
                                                    <input type="checkbox" checked id="link_preview_original"
                                                           name="link_preview_original">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
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
                                                        <li>
                                                            <label class="custom-checkbox">Use Original
                                                                <input checked type="checkbox" id="org_img_chk"
                                                                       name="org_img_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="custom-checkbox">Use Custom
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
                                                        <li>
                                                            <label class="custom-checkbox">Use Original
                                                                <input checked type="checkbox" id="org_title_chk"
                                                                       name="org_title_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="custom-checkbox">Use Custom
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
                                                        <li>
                                                            <label class="custom-checkbox">Use Original
                                                                <input checked type="checkbox" id="org_dsc_chk"
                                                                       name="org_dsc_chk">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="custom-checkbox">Use Custom
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
                                <!--Add Link Schedular-->
                                @if($type==0)
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <table class="merge-tab">
                                            <tr>
                                                <td>
                                                    <label class="custom-checkbox">Add expiration date for the link
                                                        <input type="checkbox" id="expirationEnable" name="allowExpiration">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-checkbox">Add schedules for the link
                                                        <input type="checkbox" id="addSchedule" name="allowSchedule">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="normal-body add-expiration" id="expirationArea">
                                        <p>Select date &amp; time for this link</p>
                                        <input type="text" name="date_time" id="datepicker" width="100%">
                                       <!--  <input type="hidden" name="date_time" id="dt2"> -->
                                        <p>Select a timezone</p>
                                        <select name="timezone" id="expirationTZ" class="form-control">
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
                                        <input type="text" class="form-control" name="redirect_url" id="expirationUrl" onchange="checkUrl(this.value)">
                                    </div>
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
                                </div>

                                <!--Box For Adding Geo Location-->
                                <div class="normal-box1">
                                    <div class="normal-header">
                                        <label class="custom-checkbox">Add Geo Location
                                            <input type="checkbox" id="addGeoLocation" name="addGeoLocation">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
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
                                <button type="submit" id="shorten_url_btn" class=" btn-shorten">Shorten URL</button>
                            </form>
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
        <script src="{{ URL::to('/').'/public/js/createurl.js' }}"></script>
        <!-- Choseen jquery  -->

        <!-- ManyChat -->
        <script src="//widget.manychat.com/216100302459827.js" async="async"></script>
        <script src="{{ URL::to('/').'/public/js/fineuploader.min.js' }}"></script>
       
        <script type="text/javascript">
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
                if(new_count>0){
                    for(var i=0; i<new_count; i++){
                        if($('#schedule_datepicker_'+i).length>0 && scheDt == $('#schedule_datepicker_'+i).val()){
                            swal("Sorry!", "Date already given as schedule please pick another one", "warning");
                            $('#schedule_datepicker_'+new_count).val('');
                            $('#scd_id_'+new_count).val('');
                        }
                    }
                }
            }

   /* var notValidURLs = "";
    function ValidURL(URLs) {
        notValidURLs = URLs.filter(function (URL) {
            return URL.indexOf("http://") < 0 && URL.indexOf("https://") < 0;
        });
        if (notValidURLs.length) {
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
    }*/

    /*var shortenUrlFunc = function () {
        @if($type == 'short')
        var urlToHit = 
            "{{ route('postShortUrlTier5') }}"
        @elseif($type == 'custom')
            "{{ route('postCustomUrlTier5') }}"
        @endif;
        var actualUrl = $('#givenActual_Url').val();
        var customUrl = null;
        @if ($type == 'custom')
            customUrl = $('#makeCustom_Url').val();
        @endif
        //$("#url_short_frm").submit();
    }*/
   /* $("#shorten_url_btn").on('click', function (e) {
        if ($("#cust_url_chk").prop('checked') && $("#link_preview_selector").prop('checked') && $("#link_preview_custom").prop('checked')) {
            var url_inp_len = $("#url_inp").val().trim().length;
            var url_inp = $("#url_inp").val();
            if (url_inp.indexOf(' ') != -1 ||
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
        
        if ($('#expirationEnable').prop('checked')) {
            if ($('#datepicker').val() != '' && $('#datepicker').val() != 'month/day/year hours:minutes AM/PM') {
                if ($('#expirationTZ').val() != '') {
                } else {
                    swal({
                        type: "warning",
                        title: null,
                        text: "Please pick a timezone & time for link expiration",
                        html: true
                    });
                    return false;
                }
            } else {
                swal({
                    type: "warning",
                    title: null,
                    text: "Please pick a time for link expiration",
                    html: true
                });
                return false;
            }
        }

        var actualUrl = $('.long-url').map(function (index, element) {
            return element.value;
        }).get();
        var customUrl = $('#makeCustom_Url').val();
        @if (Auth::user())
            var userId = {{Auth::user()->id}};
        @else
            var userId = 0;
        @endif
        var cust_url_flag = "{{$type}}";
        if (cust_url_flag == 'custom') {

            $.ajax({
                type: "POST",
                url: "/check_custom",
                data: {custom_url: customUrl, _token: '{{csrf_token()}}'},
                success: function (response) {
                    if (response == 1) {
                        if (ValidURL(actualUrl)) {
                            if (ValidCustomURL(customUrl)) {
                                shortenUrlFunc();
                            } else {
                                swal({
                                    type: "warning",
                                    title: "Invalid URL",
                                    text: "Custom URL is not valid",
                                    html: true
                                });
                            }
                        } else {
                            var title = actualUrl.length > 1 ?
                                "Following URLs are not valid" : "Actual URL is not valid";
                            swal({
                                type: "warning",
                                title: title,
                                text: notValidURLs.join('<br>'),
                                html: true
                            });
                        }
                    } else {
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
            
            if($('#addSchedule').prop('checked')==false)
            {
                // alert($('#addSchedule').prop('checked'))
                //if it is not custom
                if (ValidURL(actualUrl)) {
                    shortenUrlFunc();
                } else {
                    var title = actualUrl.length > 1 ? "Following URLs are not valid" : "Actual URL is not valid";
                    swal({
                        type: "warning",
                        title: title,
                        text: notValidURLs.join('<br>'),
                        html: true
                    });
                }
            }
            else
            {
                shortenUrlFunc();
            }
        }
    });*/

   /* var appURL = "{{url('/')}}";
    appURL = appURL.replace('https://', '');
    appURL = appURL.replace('http://', '');*/
    

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
</body>
</html>
