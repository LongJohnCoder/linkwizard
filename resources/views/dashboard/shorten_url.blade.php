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

<div class="main-dashboard-body">

	<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">

							<form id="url_short_frm" action="{{route('shortenUrl')}}" method="POST">
								<div class="normal-box ">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                        <label>
                            Paste An Actual URL Here
                        </label>
                        </div>
                        <div class="col-md-9 col-sm-9">
                            <input id="givenActual_Url" type="text" name="url" class="form-control long-url">
                            <div class="input-msg">* This is where you paste your long URL that you'd like to shorten.</div>
                        </div>
												<br>
												@if(strtolower($type) == 'custom')
													<div class="col-md-3 col-sm-3">
													<label>
															Paste Your Customized Url Name
													</label>
													</div>
													<div class="col-md-9 col-sm-9">
															<input id="makeCustom_Url" type="text" name="url" class="form-control long-url">
															<div class="input-msg">*Required</div>
													</div>
													<br>
												@endif
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
												<!-- <div class="custom-tags-area" id="customTags_Area" >
                        	<input class="custom-tags-contents" name="tags" type="text" class="form-control" id="shortTags_Contents" data-role="tagsinput">
												</div> -->

                        <div class="custom-tags-area" id="customTags_Area" >
                          <select data-placeholder="Choose a tag..." class="chosen-select chosen-select-header" multiple tabindex="4" id="shortTags_Contents"  name="tags">
                              <option value=""></option>
                              @for ( $i =0 ;$i<count($urlTags);$i++)
                                  <option value="{{ $urlTags[$i] }}">{{ $urlTags[$i] }}</option>
                               @endfor
                           </select>
                        </div>

                    </div>
                </div>

                <div class="normal-box1">
                    <div class="normal-header">
                        <label class="custom-checkbox">Add description
                          <input type="checkbox" id="descriptionEnable" name="descriptionEnable">
                          <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="normal-body add-description" id="descriptionArea">
                        <p>Mention description for this link</p>
                        <textarea id="descriptionContents" name="description" class = "form-control"></textarea>
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
                                  <input type="checkbox" checked id="link_preview_original" name="link_preview_original">
                                  <span class="checkmark"></span>
                                </label>
                            </li>
                            <li>
                                <label class="custom-checkbox">Use Custom
                                  <input type="checkbox" value="use-custom" id="link_preview_custom" name="link_preview_custom">
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
                                              <input checked type="checkbox" value="" id="org_img_chk" name="org_img_chk">
                                              <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom-checkbox">Use Custom
                                              <input type="checkbox" value="use-custom1" id="cust_img_chk" name="cust_img_chk">
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
                                              <input checked type="checkbox" value="" id="org_title_chk" name="org_title_chk">
                                              <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom-checkbox">Use Custom
                                              <input type="checkbox" value="use-custom1" id="cust_title_chk" name="cust_title_chk">
                                              <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="use-custom1 title-inp">
                                        <input type="text" class="form-control" id="title_inp" name="title_inp">
                                    </div>
                                </div>
                            </div>

                            <div class="white-paneel">
                                <div class="white-panel-header">Description</div>
                                <div class="white-panel-body">
                                    <ul>
                                        <li>
                                            <label class="custom-checkbox">Use Original
                                              <input checked type="checkbox" value="" id="org_dsc_chk" name="org_dsc_chk">
                                              <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom-checkbox">Use Custom
                                              <input type="checkbox" value="use-custom2" id="cust_dsc_chk" name="cust_dsc_chk">
                                              <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="use-custom2 dsc-inp">
                                        <textarea class="form-control" id="dsc_inp" name="dsc_inp"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="white-paneel">
                                <div class="white-panel-header">URL</div>
                                <div class="white-panel-body">
                                    <ul>
                                        <li>
                                            <label class="custom-checkbox">Use Original
                                              <input checked type="checkbox" value="" id="org_url_chk" name="org_url_chk">
                                              <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom-checkbox">Use Custom
                                              <input type="checkbox" value="use-custom3" id="cust_url_chk" name="cust_url_chk">
                                              <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="use-custom3 url-inp">
                                        <input type="text" class="form-control" name="url_inp" id="url_inp">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

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
        width:145px !important;
    }
</style>
<!-- ManyChat -->
<script src="//widget.manychat.com/216100302459827.js" async="async">
</script>

<script src="{{ URL::to('/').'/public/js/fineuploader.min.js' }}"></script>
<link href="{{ URL::to('/').'/public/css/fineuploader-gallery.min.css' }}" rel="stylesheet" />
<link href="{{ URL::to('/').'/public/css/fine-uploader-new.min.css' }}" rel="stylesheet" />

<script type="text/javascript">

$(".chosen-select").chosen({});

$(".chosen-container").bind('keyup',function(e) {
   if (e.which == 13 || e.which == 188)
    {
       var lastChar = e.target.value.slice(-1);
       var strVal  = e.target.value;
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

function ValidURL(str) {
		var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|ac|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
		var url = str;
		if (!regexp.test(url)) {
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

var shortenUrlFunc = function() {



	var urlToHit = @if($type == 'short') "{{ route('postShortUrlTier5') }}" @elseif($type == 'custom')  "{{ route('postCustomUrlTier5') }}" @endif;

	var actualUrl = $('#givenActual_Url').val();

	var customUrl = null;
	@if($type == 'custom')
		customUrl = $('#makeCustom_Url').val();
	@endif



	var data = {

		checkboxAddFbPixelid 	: 	$("#checkboxAddFbPixelid").prop('checked'),
		fbPixelid							: 	$("#fbPixel_id").val(),
		checkboxAddGlPixelid 	: 	$("#checkboxAddGlPixelid").prop('checked'),
		glPixelid							: 	$("#glPixel_id").val(),

		allowTag							:   $("#shortTagsEnable").prop('checked'),
		tags 									: 	$("#shortTags_Contents").tagsinput('items'),
		allowDescription      : 	$("#descriptionEnable").prop('checked'),
		searchDescription			: 	$("#descriptionContents").val(),

		link_preview_selector :   $("#link_preview_selector").prop('checked'),
		link_preview_original	: 	$("#link_preview_original").prop('checked'),
		link_preview_custom		: 	$("#link_preview_custom").prop('checked'),

		org_img_chk						: 	$("#org_img_chk").prop('checked'),
		cust_img_chk					: 	$("#cust_img_chk").prop('checked'),
		img_inp	              :   $("#img_inp").val(),

		org_title_chk					: 	$("#org_title_chk").prop('checked'),
		cust_title_chk				: 	$("#cust_title_chk").prop('checked'),
		title_inp	            :   $("#title_inp").val(),

		org_dsc_chk						: 	$("#org_dsc_chk").prop('checked'),
		cust_dsc_chk					: 	$("#cust_dsc_chk").prop('checked'),
		dsc_inp	           	 	:   $("#dsc_inp").val(),

		org_url_chk						: 	$("#org_url_chk").prop('checked'),
		cust_url_chk					: 	$("#cust_url_chk").prop('checked'),
		url_inp	            	:   $('#img_inp')[0].files[0],

		actual_url 						:		actualUrl,
		_token   							: 	"{{ csrf_token() }}"
	};

	if(customUrl !== null) {
		data['custom_url'] = customUrl;
	}

	data = JSON.stringify(data);

	$.ajax({
			type	: "POST",
			url		: urlToHit,
			data	: data,
			//processData: false ,
			contentType : 'multipart/form-data',
			//contentType	: false,       // The content type used when sending data to the server.
			cache				: false,             // To unable request pages to be cached
			processData	:	false,
			// beforeSend : function() {
			// 	manualUploader.uploadStoredFiles();
			// },
			success: function (response) {
				console.log(urlToHit);
					if(response.status=="success") {
							var shortenUrl = response.url;
							var displayHtml = "<a href="+shortenUrl+" target='_blank' id='newshortlink'>"+shortenUrl+"</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink''><i class='fa fa-clipboard'></i> Copy</button>";
							swal({
									title: "Shorten Url:",
									text: displayHtml,
									type: "success",
									html: true
							}, function() {
									//window.location.reload();
									window.location.href = response.redirect_url;
							});
							new Clipboard('#clipboardswal');
							$('#clipboardswal').on('click', function () {
									//window.location.reload();
									window.location.href = response.redirect_url;
							});
							HoldOn.close();
					}

					else if(response.status=="error") {
						swal({
								title: null,
								text: response.msg,
								type: "warning",
								html: true
						});
						HoldOn.close();
					}

					else {
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

// $("#link_preview_selector").attr("checked", false);
// $("#checkboxAddFbPixelid").attr("checked",false);
// $("#checkboxAddGlPixelid").attr("checked",false);
// $()

$("#shorten_url_btn").on('click',function(e){


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
				console.log('check_custom');
				console.log(response);
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
					swal({
							type: "warning",
							title: null,
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
							title: null,
							text: "Please Enter An URL"
						});
			}
		}


});

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
		if (thisInstance.id === "checkboxAddFbPixelid" && thisInstance["name"] === "check_fb") {
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
		if (thisInstance.id === "checkboxAddGlPixelid" && thisInstance["name"] === "check_gl") {
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
		if (thisInstance.id === "shortTagsEnable" && thisInstance["name"] === "shortTagsEnable") {
			if(thisInstance.checked) {
				$('.add-tags').show();
				$('#shortTags_Area').show();
			} else {
				$('.add-tags').hide();
				$('#shortTags_Area').hide();
				$("#shortTags_Contents").tagsinput('removeAll');
			}
		}

		//addtags for custom urls
		// if (thisInstance.id === "customTagsEnable" && thisInstance["name"] === "customTagsEnable") {
		// 	if(thisInstance.checked) {
		// 		$('#customTagsArea').show();
		// 	} else {
		// 		$('#customTagsArea').hide();
		// 		$("#customTagsContents").tagsinput('removeAll');
		// 	}
		// }

		if (thisInstance.id === "descriptionEnable" && thisInstance["name"] === "descriptionEnable") {
			if(thisInstance.checked) {
				$('#descriptionArea').show();
				$('#descriptionContents').show();
			} else {
				$('#descriptionContents').hide();
				$('#descriptionContents').val('');
				$('#descriptionArea').hide();
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


		//add short descriptions for short urls
		// if (thisInstance.id === "shortDescriptionEnable" && thisInstance["name"] === "shortDescriptionEnable") {
		// 	if(thisInstance.checked) {
		// 		$('#shortDescriptionContents').show();
		// 	} else {
		// 		$('#shortDescriptionContents').hide();
		// 		$('#shortDescriptionContents').val('');
		// 	}
		// }
    //
		// //add short descriptions for short urls
		// if (thisInstance.id === "customDescriptionEnable" && thisInstance["name"] === "customDescriptionEnable") {
		// 	if(thisInstance.checked) {
		// 		$('#customDescriptionContents').show();
		// 	} else {
		// 		$('#customDescriptionContents').hide();
		// 		$('#customDescriptionContents').val('');
		// 	}
		// }
	}

	$(document).ready(function() {

		// $("#shorten_url_btn").on("click",function(){
    //
		// });

		// $('#dashboard-tags-to-search').on('beforeItemAdd', function(event) {
		// 	var string = $(this).text();
		// 	$(this).html(string.replace(/,/g , ''));
		//   // event.item: contains the item
		//   // event.cancel: set to true to prevent the item getting added
		// });

		$("#dashboard-search-btn").on('click',function() {
			console.log('came here : submitting form');
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


		$("input[type='checkbox']").on("change", function() {
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

				if (typeof(FB) != 'undefined'
		     && FB != null ) {
		    // run the app
			} else {
			    alert('check browser settings to enable facebook sharing.. ');
			}
			});
		</script>

		<script type="text/javascript">

		    // $('input[type="checkbox"]').click(function(){
		    //     var inputValue = $(this).attr("value");
		    //     $("." + inputValue).toggle();
		    // });
		//});
		</script>


</body>
</html>
