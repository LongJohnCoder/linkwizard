$(document).ready(function () {
	$('#custom_url_status').click(function(){
		if($('#custom_url_status').is(':checked')){
			$('#customized-url-div').show();
		}else{
			$('#customized-url-div').hide();
		}
	});

	$("#makeCustom_Url").blur(function(){
    	var getCustomUrl=$("#makeCustom_Url").val();
    	if(getCustomUrl){
	    	$.ajax({
	            type: 'POST',
	            url: "/app/url/check_suffix_availability",
	            data: {suffix: getCustomUrl, _token: '{{csrf_token()}}'},
	            success: function(response){
	                if(response.status=='error'){
	                	$('#error-custom-url').html("This Url Is Already Taken!");
	                }else{
	                	$('#error-custom-url').html("");
	                }
	            }
	        });
	    }else{
	    	$('#error-custom-url').html("");
	    }
	}); 
    
    //Rotating Link Add
    var blockIndex = 0;

    $('#addCircularURL').click(function (event) {
        event.preventDefault();
        $('.actualUrl').append(nextCircularURLBlock(++blockIndex));
    });

	var nextCircularURLBlock = function (index) {
		return  '<div class="row">\n' +
			   	'	<div class="col-md-2 col-sm-2">\n' +
				'		<label>\n' +
				'			Paste Another URL Here\n' +
				'		</label>\n' +
				'	</div>\n' +
				'	<div class="col-md-8 col-sm-8">\n' +
				'		<div class="form-group">'+
				'			<input id="givenActual_Url_' + index + '" type="text" name="actual_url[' + index + ']"\n' +
				'				class="form-control">\n' +
				'		</div>'+
				'		<div class=" from-group input-msg">* This is where you paste your long URL that you\'d like\n' +
				'			to shorten.\n' +
				'		</div>\n' +
				'	</div>\n' +
				'	<div class="col-md-2 col-sm-2">\n' +
				'		<button type="button" class="btn-sm btn-primary remove-this-circular-url"\n' +
				'		><i\n' +
				'		class="fa fa-minus fa-fw"></i></button>\n' +
				'	</div>\n' +
				'</div>';
	};

    //Remove Rotating Link Field
    $('body').on('click', '.remove-this-circular-url', function () {
        $(this).parent().parent().remove();
    });
        
    //Front End Validation Of Count Down Timer
    $('#countDownContents').bind('keyup change click' ,function(){
        var countDownTime = $(this).val();
        if(countDownTime.match(/[0-9]|\./)){
            if(countDownTime<=30 && countDownTime>=1){
                $('#countDownContents').val(countDownTime);
            }else if(countDownTime>30){
                $('#countDownContents').val(30);
            }else{
                $('#countDownContents').val(1);
            }
		}else{
            swal({
                type: 'warning',
                title: 'Notification',
                text: 'Countdown time should be numeric and minimum 1 & maximum 30.'
            });
            $('#countDownContents').val(5);
        }
    });

    $("input[type='checkbox']").on("change", function () {
        maintainSidebar(this);
    });

    var maintainSidebar = function (thisInstance) {
    	//Add Facebook Pixel
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

        //Add Google Pixel
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

        //Add Tag
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

        //Add Description
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

        //Add Countdown
        if (thisInstance.id === "countDownEnable"){
            if(thisInstance.checked){
                $('#countDownArea').show();
                $('#countDownContents').show();
            } else{
                $('#countDownArea').hide();
                $('#countDownContents').val('');
                $('#countDownContents').hide();
            }
        }

        //Add Link Preview
        if (thisInstance.id === "link_preview_selector" && thisInstance["name"] === "link_preview_selector") {
            if (thisInstance.checked) {
                $('.link-preview').show();
            } else {
                $('.link-preview').hide();
            }
        }

        //Add Link Preview Original Settings
        if (thisInstance.id === 'link_preview_original') {
            if (thisInstance.checked) {
                $('#link_preview_custom').attr("checked", false);
                $('.use-custom').hide();
            } else {
                //$('#link_preview_').hide();
                //$('#link_preview_original').hide();
            }
        }
        
        //Add Link Preview Custom Settings
        if (thisInstance.id === 'link_preview_custom') {
            if (thisInstance.checked) {
                $('.use-custom').show();
                $('#link_preview_original').attr("checked", false);
            } else {
                //$('#link_preview_').hide();
                $('.use-custom').hide();
            }
        }

        //Add Link Preview Custom Settings(Original Image)
        if (thisInstance.id === "org_img_chk") {
            if (thisInstance.checked) {
                $('.img-inp').hide();
                $('#img_inp').val('');
                $('#img_inp').hide();
                $("#cust_img_chk").attr("checked", false);
            } else {
            }
        }

        //Add Link Preview Custom Settings(Custom Image)
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

        //Add Link Preview Custom Settings(Original Title)
        if (thisInstance.id === "org_title_chk") {
            if (thisInstance.checked) {
                $('.title-inp').hide();
                $('#title_inp').val('');
                $('#title_inp').hide();
                $("#cust_title_chk").attr("checked", false);
            } else {
            }
        }

        //Add Link Preview Custom Settings(Custom Title)
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

        //Add Link Preview Custom Settings(Original Description)
        if (thisInstance.id === "org_dsc_chk") {
            if (thisInstance.checked) {
                $('.dsc-inp').hide();
                $('#dsc_inp').val('');
                $('#dsc_inp').hide();
                $("#cust_dsc_chk").attr("checked", false);
            } else {
            }
        }

        //Add Link Preview Custom Settings(Custom Description)
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
    }

    $('#shorten_url_btn').click(function(event){
        $("#url_short_frm").submit();
    });
});