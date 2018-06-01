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
        <script src="{{ URL::to('/').'/public/js/createurl.js' }}"></script>

        <!-- Date time picker -->
        {{--<script src="https://cdn.rawgit.com/atatanasov/gijgo/master/dist/combined/js/gijgo.min.js" type="text/javascript"></script>--}}
        {{--<link href="https://cdn.rawgit.com/atatanasov/gijgo/master/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />--}}

        <!-- Kendo date time -->
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.common-material.min.css" />
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.min.css" />
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.516/styles/kendo.material.mobile.min.css" />
        {{--<script src="https://kendo.cdn.telerik.com/2018.2.516/js/jquery.min.js"></script>--}}
        <script src="https://kendo.cdn.telerik.com/2018.2.516/js/kendo.all.min.js"></script>
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
                                                    <input id="givenActual_Url_0" type="text" name="actual_url[0]" class="form-control">
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
                                        <input type="number" name="fbPixelid" class="form-control" id="fbPixel_id">
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
                                <!--Add Tag Start-->
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
                                <!--Add Link Preview End-->
                                {{csrf_field()}}
                                <button type="button" id="shorten_url_btn" class=" btn-shorten">Shorten URL</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Footer Start -->
        @include('contents/footer')
        <!-- Footer End -->

        <!-- Choseen jquery  -->
        <link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/prism.css' }}">
        <link rel="stylesheet" href="{{ URL::to('/').'/public/resources/js/chosen/chosen.css' }}">
        <script src="{{ URL::to('/').'/public/resources/js/chosen/chosen.jquery.js' }}" type="text/javascript"></script>
        <script src="{{ URL::to('/').'/public/resources/js/chosen/prism.js' }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ URL::to('/').'/public/resources/js/chosen/init.js' }}" type="text/javascript" charset="utf-8"></script>
        <!-- Choseen jquery  -->
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

            function dispButton(id) {
                if(id==0)
                {
                    $('#add_button_0').hide();
                }
                if(id>0)
                {
                    $('#add_button_'+id).hide();
                    $('#delete_button_'+id).show();
                }
            }

            function delTabRow(indx)
            {
                $('#special_url-'+indx).remove();
            }

    $(document).ready(function(){
        $('#expirationEnable').click(function(){
            if($(this).is(':checked'))
            {
                $('#addSchedule').prop('checked', false);
                $('#scheduleArea').hide();
                $('#day1').val('');
                $('#day2').val('');
                $('#day3').val('');
                $('#day4').val('');
                $('#day5').val('');
                $('#day6').val('');
                $('#day7').val('');
            }
        });

        $('#addSchedule').click(function(){
            if($(this).is(':checked'))
            {
                $('#expirationEnable').prop('checked', false);
                $('#expirationArea').hide();
                $('#datepicker').val('month/day/year hours:minutes AM/PM');
                $('#expirationTZ').val('');
                $('#expirationUrl').val('');
            }
        });
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
            /* link schedule check */
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
    });

    var appURL = "{{url('/')}}";
    appURL = appURL.replace('https://', '');
    appURL = appURL.replace('http://', '');
    

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

</body>
</html>
