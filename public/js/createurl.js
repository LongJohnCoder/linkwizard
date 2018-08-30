$(document).ready(function () {
    var facebookPixel=false;
    var googlePixel=false;
    var tag=false;
    var description=false;
    var countdown=false;
    var linkpreview=false;
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
				'				class="form-control actual-url" placeholder="Please Provide A Valid Url Like http://www.example.com">\n' +
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
                facebookPixel=true;
            } else {
                $('.facebook-pixel').hide();
                $('#fbPixel_id').val('');
                $('#fbPixel_id').hide();
                facebookPixel=false;
            }
        }

        //Add Google Pixel
        if (thisInstance.id === "checkboxAddGlPixelid") {
            if (thisInstance.checked) {
                $('.google-pixel').show();
                $('#glPixel_id').show();
                googlePixel=true;
            } else {
                $('.google-pixel').hide();
                $('#glPixel_id').hide();
                $('#glPixel_id').val('');
                googlePixel=false;
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

        //Add Tag
        if (thisInstance.id === "shortTagsEnable") {
            if (thisInstance.checked) {
                tag=true;
                $('.add-tags').show();
                $('#shortTags_Area').show();
            } else {
                $('.add-tags').hide();
                $('#shortTags_Area').hide();
                $("#shortTags_Contents").val('');
                var select = $(".chosen-select-header");
                select.find('option').prop('selected', false);
                select.trigger("chosen:updated");
                tag=false;
            }
        }

        //Add Description
        if (thisInstance.id === "descriptionEnable") {
            if (thisInstance.checked) {
                $('#descriptionArea').show();
                $('#descriptionContents').show();
                description=true;
            } else {
                $('#descriptionContents').hide();
                $('#descriptionContents').val('');
                $('#descriptionArea').hide();
                description=false;
            }
        }

        //Add Countdown
        if (thisInstance.id === "countDownEnable"){
            if(thisInstance.checked){
                $('#countDownArea').show();
                $('#countDownContents').show();
                countdown=true;
            } else{
                $('#countDownArea').hide();
                $('#countDownContents').val('');
                $('#countDownContents').hide();
                countdown=false;
            }
        }

        //Add Favicon
        if(thisInstance.id === "faviconEnable"){
            if(thisInstance.checked){
                $('#faviconArea').show();
                $('#faviconContents').show();
            } else{
                $('#faviconArea').hide();
                $('#faviconContents').val('');
                $('#faviconContents').hide();
            }
        }

        //Add Link Preview
        if (thisInstance.id === "link_preview_selector" && thisInstance["name"] === "link_preview_selector") {
            if (thisInstance.checked) {
                $('.link-preview').show();
                linkpreview=true;
            } else {
                $('.link-preview').hide();
                linkpreview=false;
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
    }

    //Validate Create URL before submit
    $('#shorten_url_btn').click(function(event){
        event.preventDefault();
        //Actual Link Validation
        var getUrlType=$('#type').val();
        // console.log(getUrlType);
        if(getUrlType==0){
            var originalUrl=$('#givenActual_Url_0').val().trim();
            if(!originalUrl){
                if($('#addSchedule').prop('checked')==true){
                    /* check if no schedule is given n = no schedule, y = schedule given */
                    var checkEmptySchedule = 'n';
                    /* check schedule checkbox check = checked, uncheck = not checked */
                    var scheduleCheckBox = 'check';
                    /* actual URL check */

                    /* check for daywise schedule */
                    for(var i=1; i<=7; i++){
                        var dayScheduleValue = $('#day'+i).val();
                        if(dayScheduleValue!='' && dayScheduleValue.length>0){
                            checkEmptySchedule = 'y';
                            scheduleCheckBox = 'check';
                            break;
                        }else{
                            checkEmptySchedule = 'n';
                            scheduleCheckBox = 'uncheck';
                        }
                    }

                    /* check for special schedule */

                    if(checkEmptySchedule=='n'){
                        var splCount = $('#special_url_count').val();
                        if(splCount > 0){
                            for(var i=0; i<parseInt(splCount); i++){
                                try{
                                    var dtPicker= $('#schedule_datepicker_'+i).val();
                                    var splUrl = $('#special_url_'+i).val();
                                    if(dtPicker.trim()!='' && splUrl.trim()!=''){
                                        scheduleCheckBox = 'check';
                                        checkEmptySchedule = 'y';
                                        break;
                                    }else{
                                        scheduleCheckBox = 'uncheck';
                                    }
                                }catch(err){
                                    /* error message */
                                    var dtPicker= $('#schedule_datepicker_0').val();
                                    var splUrl = $('#special_url_0').val();
                                    if(dtPicker.trim()!='' && splUrl.trim()!=''){
                                        scheduleCheckBox = 'check';
                                        checkEmptySchedule = 'y';
                                    }else{
                                        scheduleCheckBox = 'uncheck';
                                    }
                                }
                            }
                        }else{
                            var dtPicker= $('#schedule_datepicker_0').val();
                            var splUrl = $('#special_url_0').val();
                            if(dtPicker.trim()!='' && splUrl.trim()!=''){
                                scheduleCheckBox = 'check';
                                checkEmptySchedule = 'y';
                            }else{
                                scheduleCheckBox = 'uncheck';
                            }
                        }
                    }

                    var trueURL = $('#givenActual_Url_0').val();
                    if(trueURL.trim()!='' && trueURL.length>0){
                        checkEmptySchedule = 'y';
                        //var scheduleCheckBox = 'uncheck';
                    }
                    /* check schedule flag */
                    //alert(checkEmptySchedule+'-------'+scheduleCheckBox);
                    var preventSubmit = checkLinkSchedule(checkEmptySchedule, scheduleCheckBox);
                    if(preventSubmit==false){
                        return false;
                    }
                }else{
                    swal({
                        title: "Error",
                        text: "Need a Actual URL to create a short Url",
                        type: "error",
                        html: true
                    });
                    return false;
                }
            }
            else if(originalUrl){
                if($('#addSchedule').prop('checked')==true){
                    /* check if no schedule is given n = no schedule, y = schedule given */
                    var checkEmptySchedule = 'n';
                    /* check schedule checkbox check = checked, uncheck = not checked */
                    var scheduleCheckBox = 'check';
                    /* actual URL check */

                    /* check for daywise schedule */
                    for(var i=1; i<=7; i++){
                        var dayScheduleValue = $('#day'+i).val();
                        if(dayScheduleValue!='' && dayScheduleValue.length>0){
                            checkEmptySchedule = 'y';
                            scheduleCheckBox = 'check';
                            break;
                        }else{
                            checkEmptySchedule = 'n';
                            scheduleCheckBox = 'uncheck';
                        }
                    }

                    /* check for special schedule */

                    if(checkEmptySchedule=='n'){
                        var splCount = $('#special_url_count').val();
                        if(splCount > 0){
                            for(var i=0; i<parseInt(splCount); i++){
                                try{
                                    var dtPicker= $('#schedule_datepicker_'+i).val();
                                    var splUrl = $('#special_url_'+i).val();
                                    if(dtPicker.trim()!='' && splUrl.trim()!=''){
                                        scheduleCheckBox = 'check';
                                        checkEmptySchedule = 'y';
                                        break;
                                    }else{
                                        scheduleCheckBox = 'uncheck';
                                    }
                                }catch(err){
                                    /* error message */
                                    var dtPicker= $('#schedule_datepicker_0').val();
                                    var splUrl = $('#special_url_0').val();
                                    if(dtPicker.trim()!='' && splUrl.trim()!=''){
                                        scheduleCheckBox = 'check';
                                        checkEmptySchedule = 'y';
                                    }else{
                                        scheduleCheckBox = 'uncheck';
                                    }
                                }
                            }
                        }else{
                            var dtPicker= $('#schedule_datepicker_0').val();
                            var splUrl = $('#special_url_0').val();
                            if(dtPicker.trim()!='' && splUrl.trim()!=''){
                                scheduleCheckBox = 'check';
                                checkEmptySchedule = 'y';
                            }else{
                                scheduleCheckBox = 'uncheck';
                            }
                        }
                    }

                    var trueURL = $('#givenActual_Url_0').val();
                    if(trueURL.trim()!='' && trueURL.length>0){
                        checkEmptySchedule = 'y';
                        //var scheduleCheckBox = 'uncheck';
                    }
                    /* check schedule flag */
                    //alert(checkEmptySchedule+'-------'+scheduleCheckBox);
                    var preventSubmit = checkLinkSchedule(checkEmptySchedule, scheduleCheckBox);
                    if(preventSubmit==false){
                        return false;
                    }
                }else{
                    ValidURL(originalUrl);
                }
            }
            else{

                ValidURL(originalUrl);
            }
        }else if(getUrlType==1 || getUrlType==2){
            if(getUrlType==1 ){
                var rotatingUrls=$("input[name^=actual_url").map(function() {return $(this).val();}).get();
                if(!(rotatingUrls.length >1)){
                    swal({
                        title: "Error",
                        text: "Atleast Need Two URL to create Rotating Link",
                        type: "error",
                        html: true
                    });
                    return false;
                }
                for(i=0; i < rotatingUrls.length ; i++){
                    if(rotatingUrls[i]){
                        ValidURL(rotatingUrls[i]);
                    }else{
                        swal({
                            title: "Error",
                            text:  "Please Provide Url",
                            type: "error",
                            html: true
                        });
                        return false;
                    }
                }
            }else{
                var urlTitle=$('#group_url_title').val();
                if(!urlTitle){
                    swal({
                        title: "Error",
                        text:  "Please Provide Group Title",
                        type: "error",
                    });
                    return false;
                }
            }
        }else if(getUrlType==3){
          var inputFile = $('#inputfile').val();
          console.log(inputFile);
          if (inputFile === '' || inputFile === null || inputFile === undefined) {
            swal({
                title: "Error",
                text:  "Please select a file",
                type: "error",
            });
            return false;
          }
        }else{
            return false;
        }

        //Customized Url Validation
        if($('#custom_url_status').prop('checked')==true){
            var customUrl=$('#makeCustom_Url').val().trim();
            if(!customUrl){
                swal({
                    title: "Error",
                    text: "Customize Url Is Required",
                    type: "error",
                    html: true
                });
                return false;
            }
        }

        if(facebookPixel==true){
            var fbpxid=$('#fbPixel_id').val().trim();
            if(!fbpxid){
                swal({
                    title: "Error",
                    text: "If you want to active facebook pixel please provide a value!",
                    type: "error",
                    html: true
                });
                return false;
            }
        }

        if(googlePixel==true){
            var gpxid=$('#glPixel_id').val().trim();
            if(!gpxid){
                swal({
                    title: "Error",
                    text: "If you want to active google pixel please provide a value!",
                    type: "error",
                    html: true
                });
                return false;
            }
        }

        if(tag==true){
            var tags = $("#shortTags_Contents").chosen().val();
            if(!tags){
                swal({
                    title: "Error",
                    text: "If you want to active tags please select a tag!",
                    type: "error",
                    html: true
                });
                return false;
            }
        }

        if(description==true){
            var getdescription = $("#descriptionContents").val().trim();
            if(!getdescription){
                swal({
                    title: "Error",
                    text: "If you want to active description please provide some description!",
                    type: "error",
                    html: true
                });
                return false;
            }
        }

        if(countdown==true){
            var timer = $("#countDownContents").val().trim();
            if(!timer){
                swal({
                    title: "Error",
                    text: "If you want to provide custom time please provide time in seconds!",
                    type: "error",
                    html: true
                });
                return false;
            }
        }

        // expiration validation /
        if ($('#expirationEnable').prop('checked')) {
            if ($('#datepicker').val() != '' && $('#datepicker').val() != 'month/day/year hours:minutes AM/PM') {
                if ($('#expirationTZ').val() == '') {
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
        $(".main-dashboard-body").busyLoad("show", {
          maxSize: "150px",
          minSize: "150px",
          text: "Please Wait ...",
          fontSize: "3rem",
          color: "#01579b",
        });
        $("#url_short_frm").submit();
    });

    $('.actual-url').blur(function(){
        if($(this).val().trim()){
            ValidURL($(this).val().trim());
        }
    });

    function ValidURL(str) {
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if(!pattern.test(str)) {
            swal({
                title: "Error",
                text: "Please enter valid URL.",
                type: "error",
                html: true
            });
            return false;
        } else {
            return true;
        }
    }

    // checking if schedule is given or not /

    function checkLinkSchedule(scheduleFlag, checkBox){
        if(scheduleFlag=='y'){
            if(checkBox=='uncheck'){
                $('#addSchedule').prop('checked', false);
                $('#scheduleArea').hide();
            }
        }else{
            swal({
                title: 'Sorry!',
                text: 'Please either enter a Actual URL or schedule URL',
                type: 'warning'
            });
            return false;
        }
    }
    // create DateTimePicker from input HTML element


    $("#datepicker").kendoDateTimePicker({
        value: '',
        min: new Date(),
        dateInput: true,
        interval: 5,
        change: onChange
    });

    $("#datepicker").bind("click", function(){
        $(this).data("kendoDateTimePicker").open( function(){
            $("#datepicker").bind("click", function(){
                $(this).data("kendoTimePicker").open();
            });
        });
    });

    function onChange(){
        var scheDt = $("#schedule_datepicker_0").val();
        $('#scd_id_0').val(scheDt);
    }

    $("#schedule_datepicker_0").kendoDatePicker({
        value: '',
        min: new Date(),
        change: onChange,
        dateInput: false
    });



    $('#expirationEnable').click(function(){
        if($(this).is(':checked')){
            $('#addSchedule').prop('checked', false);
            $('#addGeoLocation').prop('checked', false);
            $('#scheduleArea').hide();
            $('#geo-location-body').hide();
            $('#day1').val('');
            $('#day2').val('');
            $('#day3').val('');
            $('#day4').val('');
            $('#day5').val('');
            $('#day6').val('');
            $('#day7').val('');
        }

        /* empty special schedule */
        var splCount = $('#special_url_count').val();
        if(splCount>0){
            var countRow = 1;
            for(var i=0; i<splCount; i++){
                $('#special_url-'+countRow).remove();
                countRow = parseInt(countRow)+1;
            }
        }

        $('#schedule_datepicker_0').val('');
        $('#scd_id_0').val('');
        $('#special_url_0').val('');
    });

    $('#addSchedule').click(function(){
        if($(this).is(':checked')){
            $('#expirationEnable').prop('checked', false);
            $('#addGeoLocation').prop('checked', false);
            $('#expirationArea').hide();
            $('#geo-location-body').hide();
            $('#datepicker').val('month/day/year hours:minutes AM/PM');
            $('#expirationTZ').val('');
            $('#expirationUrl').val('');
        }
    });

});

//Day-wise url validation /
    function checkUrl(urlVal){
        if(urlVal.length>0){
            var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!-\/]))?/;
            if(!pattern.test(urlVal)){
                swal({
                    type: 'error',
                    title: 'Invalid URL!',
                    text: 'Text given instead of an URL',
                });
                return false;
            }else{
                var urlCount = urlVal.split(":");
                if(urlCount.length!=2){
                    swal({
                        type: 'error',
                        title: 'Invalid URL!',
                        text: 'Text given instead of an URL',
                    });
                    return false;
                }
            }
        }
    }

     // Add more tab for special schedules /
    function dispButton(id){
        if(id>0){
            $('#add_button_'+id).hide();
            $('#delete_button_'+id).show();
        }
    }

    function onChange() {
        // var a = $(this).val();
        var kndDt = $('#datepicker').val();
        $("#dt2").val(kndDt);
    }

    // Delete special day tab /
    function delTabRow(indx){
        $('#special_url-'+indx).remove();
    }
