<!DOCTYPE html>
<html lang="en">

    <!-- head start -->
	@include('contents/head')
    <!-- head end -->
    <body>
        <link rel="stylesheet" href="{{ URL('/')}}/public/css/selectize.legacy.css" />
        <link href="{{ URL::to('/').'/public/css/footer.css'}}" rel="stylesheet" />
        <script src="{{ URL::to('/').'/public/js/selectize.js' }}"></script>
        <script src="{{ URL::to('/').'/public/js/selectize_index.js' }}"></script>
        <!-- Date time picker -->
        <script src="https://cdn.rawgit.com/atatanasov/gijgo/master/dist/combined/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://cdn.rawgit.com/atatanasov/gijgo/master/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <style>
            /* hidden display div for link schedule panel */
            .schedule-day{
                /*display: none;*/
            }
            #scheduleArea{
                padding: 10px;
            }
        </style>
        <script>
            $(document).ready(function () {
                $('#datepicker').datetimepicker({
                    uiLibrary: 'bootstrap'
                });
            });
        </script>
<!-- Header Start -->
@include('contents/header')
<!-- Header End -->
<div class="main-dashboard-body">
    <section class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <form id="url_short_frm" action="{{route('shortenUrl')}}" method="POST"
                          enctype="multipart/form-data" files="true" class="form form-horizaontal" role="form">
                        <input type="hidden" value="{{$type}}" name="type">
                        <input type="hidden" value="logedin" name="loggedin">
                        <div class="normal-box ">
                            <div class="actualUrl">
                                <div class="row form-group">
                                    <div class="col-md-3 col-sm-3">
                                        <label>
                                            Paste An Actual URL Here
                                        </label>
                                    </div>
                                    <div class="col-md-9 col-sm-9">
                                        <button id="addCircularURL" type="button" class="btn btn-sm btn-primary"
                                                style="max-width: 40px; margin: 0 0 10px 30px"><i
                                                    class="fa fa-plus fa-fw"></i></button>
                                        <input id="givenActual_Url_0" type="text" name="actual_url[0]"
                                               class="form-control long-url pull-left">
                                        <div class="input-msg">* This is where you paste your long URL that you'd like
                                            to shorten.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if(strtolower($type) == 'custom')
                                    <div class="col-md-3 col-sm-3">
                                        <label>
                                            Paste Your Customized Url Name
                                        </label>
                                    </div>
                                    <div class="col-md-9 col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">{{config('settings.APP_REDIRECT_HOST')}}
                                                /</span>
                                            <input id="makeCustom_Url" type="text" name="custom_url"
                                                   class="form-control" style="max-width: 300px">
                                        </div>
                                        <div class="input-msg">*Required</div>
                                    </div>
                                    <br> @endif
                            </div>
                        </div>
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Add facebook pixel
                                    <input type="checkbox" id="checkboxAddFbPixelid" name="checkboxAddFbPixelid">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body facebook-pixel">
                                <p>Paste Your Facebook-pixel-id Here</p>
                                <input type="number" name="fbPixelid" class="form-control" id="fbPixel_id">
                            </div>
                        </div>
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
                        <!-- <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Add tags
                                  <input type="checkbox" value="google-pixel">
                                  <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="normal-body google-pixel">
                                <p>Mention tags for this link</p>
                                <input type="text" class="form-control">
                            </div>
                        </div> -->
                        <div class="normal-box1">
                            <div class="normal-header">
                                <label class="custom-checkbox">Add tags
                                    <input type="checkbox" id="shortTagsEnable" name="allowTag">
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
                                        @for ( $i =0 ;$i
                                        <count($urlTags);$i++)
                                            <option value="{{ $urlTags[$i] }}">{{ $urlTags[$i] }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
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
                    </div>
                </div>

                <div class="normal-box1">
                    <div class="normal-header">
                        <label class="custom-checkbox">Add expiration date for the link
                            <input type="checkbox" id="expirationEnable" name="allowExpiration">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="normal-body add-expiration" id="expirationArea">
                        <p>Select date &amp; time for this link</p>
                        <input id="datepicker" width="100%" name="date_time"/>
                        <p>Select a timezone</p>
                        <select name="timezone" id="expirationTZ">
                            <option value="">Select from list</option>
                            <option value="America/New_York">Eastern Time</option>
                            <option value="America/Chicago">Central Time</option>
                            <option value="America/Denver">Mountain Time</option>
                            <option value="America/Los_Angeles">Pacific Time</option>
                            <option value="America/Phoenix">Mountain no DST</option>
                            <option value="America/Anchorage">Alaska</option>
                            <option value="America/Adak">Hawaii</option>
                            <option value="Hawaii no DST">Pacific/Honolulu</option>
                        </select>
                        <p>Select a redirection page url after expiration</p>
                        <input type="text" name="redirect_url" id="expirationUrl">
                    </div>
                </div>
                <div class="normal-box1">
                    <div class="normal-header">
                        <label class="custom-checkbox">Add Schedules for the link
                            <input type="checkbox" id="addSchedule" name="allowSchedule">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="normal-body add-link-schedule" id="scheduleArea">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Daywise schedule</a></li>
                            <li><a data-toggle="tab" href="#menu1">Special schedule</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <h4>Daywise schedule</h4>
                                <div id="day-1">
                                    <h5 class="text-muted">Link For Monday</h5>
                                    <input type="text" class="form-control" name="day1" id="day1" placeholder="Link for monday">
                                </div>
                                <div id="day-2" class="schedule-day">
                                    <h5 class="text-muted">Link For Tuesday</h5>
                                    <input type="text" class="form-control" name="day2" id="day2" placeholder="Link for tuesday">
                                </div>
                                <div id="day-3" class="schedule-day">
                                    <h5 class="text-muted">Link For Wednesday</h5>
                                    <input type="text" class="form-control" name="day3" id="day3" placeholder="Link for wednesday">
                                </div>
                                <div id="day-4" class="schedule-day">
                                    <h5 class="text-muted">Link For Thursday</h5>
                                    <input type="text" class="form-control" name="day4" id="day4" placeholder="Link for thursday">
                                </div>
                                <div id="day-5" class="schedule-day">
                                    <h5 class="text-muted">Link For Friday</h5>
                                    <input type="text" class="form-control" name="day5" id="day5" placeholder="Link for friday">
                                </div>
                                <div id="day-6" class="schedule-day">
                                    <h5 class="text-muted">Link For Saturday</h5>
                                    <input type="text" class="form-control" name="day6" id="day6" placeholder="Link for saturday">
                                </div>
                                <div id="day-7" class="schedule-day">
                                    <h5 class="text-muted">Link For Sunday</h5>
                                    <input type="text" class="form-control" name="day7" id="day7" placeholder="Link for sunday">
                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <h4>Special schedule</h4>
                                <input type="hidden" id="special_url_count" value="0">
                                <table width="100%" id="special_url_tab">
                                    <tr id="special_url-0">
                                        <td>
                                            <input type="date" name="special_date[]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="special_date_redirect_url[]" class="form-control" placeholder="Enter your url here">
                                        </td>
                                        <td>
                                            {{--<a href="#">Delete</a>--}}
                                        </td>
                                    </tr>
                                </table>
                                <a class="btn btn-primary btn-sm" onclick="addMoreSpecialLink()">Add more</a>
                            </div>
                        </div>
                    </div>

                        {{--<button class="btn btn-sm btn-default">Previous</button>--}}
                        {{--<button class="btn btn-sm btn-success">Next</button>--}}
                </div>
                        
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
        width: 100% !important;
    }
</style>
<!-- ManyChat -->
<script src="//widget.manychat.com/216100302459827.js" async="async"></script>
<script src="{{ URL::to('/').'/public/js/fineuploader.min.js' }}"></script>
<link href="{{ URL::to('/').'/public/css/fineuploader-gallery.min.css' }}" rel="stylesheet"/>
<link href="{{ URL::to('/').'/public/css/fine-uploader-new.min.css' }}" rel="stylesheet"/>
<script type="text/javascript">
    /* Spcial Schedule tab add */

    function addMoreSpecialLink() {
        var special_url_count = $("#special_url_count").val();
        var new_count = parseInt(special_url_count) + 1;
        $.get("{{route('ajax_schedule_tab')}}?tab_count=" + new_count, function (data, status, xhr) {
            if (xhr.status == 200) {
                $('#special_url_tab').append(data);
            }
            $("#special_url_count").val(new_count);
        })
    }

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

    var notValidURLs = "";
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
    }

    var shortenUrlFunc = function () {
        var urlToHit = @if($type == 'short')
            "{{ route('postShortUrlTier5') }}"
        @elseif($type == 'custom')
            "{{ route('postCustomUrlTier5') }}"
        @endif;
        var actualUrl = $('#givenActual_Url').val();
        var customUrl = null;
        @if ($type == 'custom')
            customUrl = $('#makeCustom_Url').val();
        @endif
        $("#url_short_frm").submit();
    }
    $("#shorten_url_btn").on('click', function (e) {
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
        /*  expiration validation  */
        if ($('#expirationEnable').prop('checked')) {
            if ($('#datetime').val() != '') {
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
    });

    var appURL = "{{url('/')}}";
    appURL = appURL.replace('https://', '');
    appURL = appURL.replace('http://', '');
    var maintainSidebar = function (thisInstance) {
        //for url
        if (thisInstance.id === "org_url_chk") {
            if (thisInstance.checked) {
                $('.url-inp').hide();
                $('#url_inp').val('');
                $('#url_inp').hide();
                $("#cust_url_chk").attr("checked", false);
            } else {
            }
        }
        if (thisInstance.id === "cust_url_chk") {
            if (thisInstance.checked) {
                $('.url-inp').show();
                $('#url_inp').show();
                $("#org_url_chk").attr("checked", false);
            } else {
                $('.url-inp').hide();
                $('#url_inp').hide();
                $('#url_inp').val('');
            }
        }
        //for description
        if (thisInstance.id === "org_dsc_chk") {
            if (thisInstance.checked) {
                $('.dsc-inp').hide();
                $('#dsc_inp').val('');
                $('#dsc_inp').hide();
                $("#cust_dsc_chk").attr("checked", false);
            } else {
            }
        }
        if (thisInstance.id === "cust_dsc_chk") {
            if (thisInstance.checked) {
                $('.dsc-inp').show();
                $('#dsc_inp').show();
                $("#org_dsc_chk").attr("checked", false);
            } else {
                $('.dsc-inp').hide();
                $('#dsc_inp').hide();
                $('#dsc_inp').val('');
            }
        }
        //for title
        if (thisInstance.id === "org_title_chk") {
            if (thisInstance.checked) {
                $('.title-inp').hide();
                $('#title_inp').val('');
                $('#title_inp').hide();
                $("#cust_title_chk").attr("checked", false);
            } else {
            }
        }

        if (thisInstance.id === "cust_title_chk") {
            if (thisInstance.checked) {
                $('.title-inp').show();
                $('#title_inp').show();
                $("#org_title_chk").attr("checked", false);
            } else {
                $('.title-inp').hide();
                $('#title_inp').hide();
                $('#title_inp').val('');
            }
        }

        //for image
        if (thisInstance.id === "org_img_chk") {
            if (thisInstance.checked) {
                $('.img-inp').hide();
                $('#img_inp').val('');
                $('#img_inp').hide();
                $("#cust_img_chk").attr("checked", false);
            } else {
            }
        }

        if (thisInstance.id === "cust_img_chk") {
            if (thisInstance.checked) {
                $('.img-inp').show();
                $('#img_inp').show();
                $("#org_img_chk").attr("checked", false);
            } else {
                $('.img-inp').hide();
                $('#img_inp').hide();
                $('#img_inp').val('');
            }
        }

        //alert(1234);
        //facebook analytics checkbox for short urls
        if (thisInstance.id === "checkboxAddFbPixelid") {
            if (thisInstance.checked) {
                $('.facebook-pixel').show();
                $('#fbPixel_id').show();
            } else {

                $('.facebook-pixel').hide();
                $('#fbPixel_id').val('');
                $('#fbPixel_id').hide();
            }
        }
        //google analytics checkbox for custom urls
        if (thisInstance.id === "checkboxAddGlPixelid") {
            if (thisInstance.checked) {
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
            if (thisInstance.checked) {

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
            if (thisInstance.checked) {
                $('#descriptionArea').show();
                $('#descriptionContents').show();
            } else {
                $('#descriptionContents').hide();
                $('#descriptionContents').val('');
                $('#descriptionArea').hide();
            }
        }

        if (thisInstance.id === "expirationEnable") {
            if (thisInstance.checked) {
                $('#expirationArea').show();
                //$('#descriptionContents').show();
                $('#datepicker').prop('required', true);
                $('#expirationTZ').prop('required', true);
            } else {
                $('#datepicker').val('');
                $('#expirationTZ').val('');
                $('#expirationUrl').val('');
                $('#expirationArea').hide();

                $('#datepicker').prop('required', false);
                $('#expirationTZ').prop('required', false);
            }
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

        if (thisInstance.id === "link_preview_selector" && thisInstance["name"] === "link_preview_selector") {
            if (thisInstance.checked) {
                $('.link-preview').show();
            } else {
                $('.link-preview').hide();
            }
        }

        if (thisInstance.id === 'link_preview_original') {
            if (thisInstance.checked) {
                $('#link_preview_custom').attr("checked", false);
                $('.use-custom').hide();
            } else {
                //$('#link_preview_').hide();
                //$('#link_preview_original').hide();
            }
        }

        if (thisInstance.id === 'link_preview_custom') {
            if (thisInstance.checked) {
                $('.use-custom').show();
                $('#link_preview_original').attr("checked", false);
            } else {
                //$('#link_preview_').hide();
                $('.use-custom').hide();
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


        $("input[type='checkbox']").on("change", function () {
            maintainSidebar(this);
        });


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
            if (to === null) {
                $(this).focus();
                $(this).parent().append('<p style="color: #f00">End cate can not be null.</p>');
            }
        });
    });
</script>
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
    $(document).ready(function () {

        if (typeof(FB) != 'undefined' &&
            FB != null) {
            // run the app
        } else {
            alert('check browser settings to enable facebook sharing.. ');
        }
    });
</script>
<script>
    (function (document) {
        $(document).ready(function () {
            var nextCircularURLBlock = function (index) {
                return '<div class="row form-group">\n' +
                '                                    <div class="col-md-3 col-sm-3">\n' +
                '                                        <label>\n' +
                '                                            Paste Another URL Here\n' +
                '                                        </label>\n' +
                '                                    </div>\n' +
                '                                    <div class="col-md-9 col-sm-9">\n' +
                '                                        <button type="button" class="btn btn-sm btn-primary remove-this-circular-url"\n' +
                '                                                style="max-width: 40px; margin: 0 0 10px 30px"><i\n' +
                '                                                    class="fa fa-minus fa-fw"></i></button>\n' +
                '                                        <input id="givenActual_Url_' + index + '" type="text" name="actual_url[' + index + ']"\n' +
                '                                               class="form-control long-url pull-left">\n' +
                '                                        <div class="input-msg">* This is where you paste your long URL that you\'d like\n' +
                '                                            to shorten.\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                </div>';
            };

            var blockIndex = 0;

            $('#addCircularURL').click(function () {
                $('.actualUrl').append(nextCircularURLBlock(++blockIndex));
            });

            $('body').on('click', '.remove-this-circular-url', function () {
                $(this).parent().parent().remove();
            });
        });
    })(document);
</script>
</body>
</html>
