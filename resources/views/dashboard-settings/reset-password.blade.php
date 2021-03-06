<!DOCTYPE html>

<!-- head of th page -->
<html lang="en">
	@include('contents/head')
<body>
<!-- head end -->

<link rel="stylesheet" href="{{ URL('/')}}/public/css/selectize.legacy.css" />
<script src="{{ URL::to('/').'/public/js/selectize.js' }}"></script>
<script src="{{ URL::to('/').'/public/js/selectize_index.js' }}"></script>

<!-- Header Start -->
@include('contents/header')
<!-- Header End -->


<!-- search div -->

<!-- search div ends -->
<!-- Messenger chatbot extension -->
@include('chatbot_extension')

<div class="main-dashboard-body">
  <div class="container centered box" >
    <div class="elelment">

      <div class="col-md-8 col-md-offset-2">

      </div><br>
      <div class="col-md-8 col-md-offset-2 form">
        <div>
          @if(\Session::has('errs'))
              <div class="alert alert-danger">
                  <p>{{\Session::get('errs')}}</p>
              </div>
          @endif

          @if(\Session::has('forget_success'))
              <div class="alert alert-success">
                  <p>{{\Session::get('forget_success')}}</p>
              </div>
          @endif
        </div>
        <div class="element-main">
         <h2>Reset Your Existing Password Here</h2>
      		<form class="form" method="post" action="{{route('setPasswordSettings')}}" id="set-passwrd-form">
            {{csrf_field()}}

              <!-- Sign Up Form -->
              <!-- Text input-->
              <div class="control-group form-group">
                  <label for="Name" class="control-label">Registered Email:</label>
                  <div class="controls">
                      <input class="form-control" type="email" name="email" placeholder="Your e-mail address" value="{{$user->email}}" readonly>
                  </div>
              </div>

              <!-- Old Password input-->
              <div class="control-group form-group">
                  <label for="password" class="control-label">Old Password:</label>
                  <div class="controls">
                      <input class="form-control" type="password" name="old_password" placeholder="Set Password" value="" id="old_password1">
                  </div>
              </div>
              <!-- New Password input-->
              <div class="control-group form-group">
                  <label for="password" class="control-label">New Password:</label>
                  <div class="controls">
                      <input class="form-control" type="password" name="new_password" placeholder="Set Password" value="" id="new_password1">
                  </div>
              </div>
              <!-- Text input-->
              <div class="control-group form-group">
                  <label for="password_confirmation" class="control-label">Confirm New Password:</label>
                  <div class="controls">
                      <input class="form-control" type="password" name="password_confirmation" placeholder="Set Confirm Password" value="" id="password_confirmation1">
                  </div>
              </div>
              <!-- Button -->
              <div class="control-group form-group">
                  <div class="controls">
                      <input class="form-control btn btn-success" type="submit" value="submit">
                  </div>
              </div>
          </form>
      	</div>
      </div>
    </div>
  </div>
  <br>
  <br>
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

var appURL = "{{url('/')}}";
appURL = appURL.replace('https://','');
appURL = appURL.replace('http://','');

console.log('appURL : ',appURL);

// var giveMyTags = function() {
// 	$.ajax({
// 		type 	:	"POST",
// 		url		:	"{{route('giveMyTags')}}",
// 		data	: {_token:'{{csrf_token()}}'},
// 		success : function(res) {
// 			console.log(res);
// 			var tagsArray = [];
// 			for(var i = 0 ; i < res.data.length ; i ++) {
// 				var ob = {tag : res.data[i]};
// 				console.log('each ob : ',ob);
// 				tagsArray.push(ob);
// 			}
// 			console.log('final tags : ',tagsArray);
// 			$('#shortTagsContentss').selectize({
// 				maxItems: null,
// 				valueField: 'tag',
// 				labelField: 'tag',
// 				searchField: 'tag',
// 				options: tagsArray,
// 				create: true
// 			});
// 		},
// 		error : function(res) {
// 			console.log(res);
// 		}
// 	});
// }

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

		// $('#dashboard-tags-to-search').on('beforeItemAdd', function(event) {
		// 	var string = $(this).text();
		// 	$(this).html(string.replace(/,/g , ''));
		//   // event.item: contains the item
		//   // event.cancel: set to true to prevent the item getting added
		// });

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

		// $("#dashboard-search-form").on('submit',function(e){
		// 	console.log('form submit handler called');
		// 	e.preventDefault();
		// });

		$("#dashboard-search").on('click',function() {
			var tags = $("#dashboard-tags-to-search").tagsinput('items');
			var text = $("#dashboard-text-to-search").val();
			console.log('tags :',tags,' text: ',text);
		});

		// $('.shortTagsContents').tagsinput({
    //   	allowDuplicates: false,
		// 		maxChars: 20,
    //     // itemValue: 'id',  // this will be used to set id of tag
    //     // itemText: 'label' // this will be used to set text of tag
    // });
		// $('.customTagsContents').tagsinput({
    //   	allowDuplicates: false,
		// 		maxChars: 20,
    //     // itemValue: 'id',  // this will be used to set id of tag
    //     // itemText: 'label' // this will be used to set text of tag
    // });
		// $('.dashboard-tags-to-search').tagsinput({
    //   	allowDuplicates: false,
		// 		maxChars: 20,
		// 		maxTags: 3
    //     // itemValue: 'id',  // this will be used to set id of tag
    //     // itemText: 'label' // this will be used to set text of tag
    // });


		$(":checkbox").on("change", function() {
			maintainSidebar(this);
    });



		// $('#checkboxAddGlPixelid1, input[type="checkbox"]').on('click', function(){
		// 	if($(this).prop("checked") == true){
		// 			$('#glPixelid1').show();
    //   }
    //   else if($(this).prop("checked") == false){
		// 			$('#glPixelid1').hide();
		// 			$('#glPixelid1').val('');
    //   }
		// });
    //
		// $('#checkboxAddFbPixelid1, input[type="checkbox"]').on('click', function(){
		// 	if($(this).prop("checked") == true){
		// 			$('#fbPixelid1').show();
    //   }
    //   else if($(this).prop("checked") == false){
		// 			$('#fbPixelid1').hide();
		// 			$('#fbPixelid1').val('');
    //   }
		// });

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

										var checkboxAddFbPixelid 	= 	$("#checkboxAddFbPixelid1").prop('checked');
										var fbPixelid							= 	$("#fbPixelid1").val();
										var checkboxAddGlPixelid 	= 	$("#checkboxAddGlPixelid1").prop('checked');
										var glPixelid							= 	$("#glPixelid1").val();
										var allowTag							=   $("#customTagsEnable").prop('checked');
										var tags 									= 	$("#customTagsContents").tagsinput('items');
										var allowDescription      = 	$("#customDescriptionEnable").prop('checked');
										var searchDescription			= 	$("#customDescriptionContents").val();

                    $.ajax({
	                    type:"POST",
	                    url:"/check_custom",
	                    data: {custom_url: customUrl , _token:'{{csrf_token()}}'},
	                    success:function(response){
	                    	console.log('check_custom');
	                    	console.log(response);
	                    	if(response == 1)
	                    	{
	                    		console.log(response);
	                    		if (ValidURL(actualUrl))
			                    {
			                        if (ValidCustomURL(customUrl))
			                        {
			                            $.ajax({
			                                type: "POST",
			                                url: "{{ route('postCustomUrlTier5') }}",
			                                data: {
																					checkboxAddFbPixelid 	: checkboxAddFbPixelid,
																					fbPixelid							: fbPixelid,
																					checkboxAddGlPixelid 	: checkboxAddGlPixelid,
																					glPixelid 						: glPixelid,
			                                    actual_url						: actualUrl,
			                                    custom_url						: customUrl,
			                                    user_id								: userId,
																					allowTag							: allowTag,
																					tags									: tags,
																					allowDescription			: allowDescription,
																					searchDescription			: searchDescription,
			                                    _token: "{{ csrf_token() }}"
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
			                        }
			                        else
			                        {
			                            swal({
			                                type: "warning",
			                                title: null,
			                                text: "Please Enter A Custom URL<br>It Should Be AlphaNumeric",
			                                html: true
			                            });
			                        }
			                    }
			                    else
			                    {
			                        swal({
			                            type: "warning",
			                            title: null,
			                            text: "Please Enter An URL"
			                        	});
			                    }
	                    	}
	                    	else
	                    	{
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

                    // var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|ac|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
                    // var url = str;
                    // if (!regexp.test(url)) {
                    //     return false;
                    // } else {
                    //     return true;
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

                $('#swalbtn').click(function() {
                    var url = $('#givenUrl').val();
                    var validUrl = ValidURL(url);
                    @if (Auth::user())
                        var userId = {{ Auth::user()->id }};
                    @else
                        var userId = 0;
                    @endif

										var checkboxAddFbPixelid 	= 	$("#checkboxAddFbPixelid").prop('checked');
										var fbPixelid							= 	$("#fbPixelid").val();
										var checkboxAddGlPixelid 	= 	$("#checkboxAddGlPixelid").prop('checked');
										var glPixelid							= 	$("#glPixelid").val();
										var allowTag							=   $("#shortTagsEnable").prop('checked');
										var tags 									= 	$("#shortTagsContents").tagsinput('items');
										var allowDescription      = 	$("#shortDescriptionEnable").prop('checked');
										var searchDescription			= 	$("#shortDescriptionContents").val();

                    if(url) {
                        if(validUrl) {
                            HoldOn.open(options);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('postShortUrlTier5') }}",
                                data: {
																	url										: url,
																	user_id								: userId,
																	checkboxAddFbPixelid 	: checkboxAddFbPixelid,
																	fbPixelid 						: fbPixelid,
																	checkboxAddGlPixelid 	: checkboxAddGlPixelid,
																	glPixelid 						: glPixelid,
																	allowTag							: allowTag,
																	tags									: tags,
																	allowDescription			: allowDescription,
																	searchDescription			: searchDescription,
																	_token: "{{ csrf_token() }}"},
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
            $.ajax({
                type: 'post',
                url: "{{ route('postFetchChartData') }}",
                data: {
									'user_id': '{{ $user->id }}',
									'_token': '{{ csrf_token() }}',
									textToSearch : textToSearch,
									tagsToSearch : tagsToSearch,
									pageLimit    : pageLimit
								},
                success: function(response) {
                	var chartDataStack = [];
										var urlSeries = [];
										if (response.urls.length > 0) {
											var ur_len = response.urls.length;
											for(var i = 0 ; i < ur_len ; i ++) {
												var ur_obj = {
													name 	: response.urls[i]['name'],
													id 		:	response.urls[i]['name'],
													data 	:	response.urlStat[i]
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

				/*if (typeof(FB) != 'undefined'
		     && FB != null ) {
		    // run the app
			} else {
			    alert('check browser settings to enable facebook sharing.. ');
			}*/
			});
		</script>

</body>
</html>
