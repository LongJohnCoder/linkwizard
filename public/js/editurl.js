$(document).ready(function () {

    google.charts.load('current', {
        'packages':['geochart'],
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
    });

    //If Geolocation Is Active
    if($('#editGeoLocation').is(":checked")) {
        if($('#allow-all').is(":checked")) {
            google.charts.setOnLoadCallback(drawRegionsAllowMap);
        }else if($('#deny-all').is(":checked")){
            google.charts.setOnLoadCallback(drawRegionsDenyMap);
        }
        $('#geo-location-body').show();
    }else{
        $('#geo-location-body').hide();
    }

    $('#editGeoLocation').click(function(){
        if($('#editGeoLocation').is(":checked")) {
            $('#expirationEnable').prop('checked', false);
            $('#addSchedule').prop('checked', false);
            $('#geo-location-body').show();
            $('#scheduleArea').hide();
            $('#expirationArea').hide();
            if($('#allow-all').is(":checked")) {
                google.charts.setOnLoadCallback(drawRegionsAllowMap);
            }else if($('#deny-all').is(":checked")){
                google.charts.setOnLoadCallback(drawRegionsDenyMap);
            }
        }else{
            $('#geo-location-body').hide();
        }
    });


	//Rotating Link Add
    var blockIndex = parseInt(($("#total_no_link").val())-1);
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
				' 		<input type="hidden" name="url_id[]" value="0">'+
				'			<input id="givenActual_Url_' + index + '" type="text" name="actual_url[]"\n' +
				'				class="form-control" placeholder="Please Provide A Valid Url Like http://www.example.com">\n' +
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

    //Click On Allow All Checkbox in geolocation
    $('#allow-all').click(function() {
        if($(this).is(":checked")) {
            $('#deny-all').prop('checked', false);
            $('#allowable-country').html("");
            $('#denied-country').html("");
             google.charts.setOnLoadCallback(drawRegionsAllowMap);
        }else{
            $('#deny-all').prop('checked', true);
            $('#allowable-country').html("");
            $('#denied-country').html("");
            google.charts.setOnLoadCallback(drawRegionsDenyMap);
        }
    });

    //Click On Deny All Checkbox in geolocation
    $('#deny-all').click(function() {
        if($(this).is(":checked")) {
            $('#allow-all').prop('checked', false);
            $('#allowable-country').html("");
            $('#denied-country').html("");
            google.charts.setOnLoadCallback(drawRegionsDenyMap);
        }else{
            $('#allow-all').prop('checked', true);
            $('#allowable-country').html("");
            $('#denied-country').html("");
            google.charts.setOnLoadCallback(drawRegionsAllowMap);
        }
    });

    //Add Tag
    $(".chosen-select").chosen({});

    //Add Tag
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

    //validation on submit
    $('#edit-short-url').click(function(event){
        event.preventDefault();
        var getUrlType=$('#type').val();
        if(getUrlType==0){
            var originalUrl=$('#givenActual_Url').val().trim();
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

                    var trueURL = $('#givenActual_Url').val();
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

                    // var trueURL = $('#givenActual_Url_0').val();alert(trueURL);
                    // if(trueURL.trim()!='' && trueURL.length>0){
                    //     checkEmptySchedule = 'y';
                    //     //var scheduleCheckBox = 'uncheck';
                    // }
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
        }else if(getUrlType==1){
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
        }else if(getUrlType==2){
            var groupTitle=$('#group_url_title').val().trim();
            if(!groupTitle){
                swal({
                    title: "Error",
                    text: "Need Group Title",
                    type: "error",
                    html: true
                });
                return false;
            }
        }else if(getUrlType==3){
          var inputfile = $('#inputfile').val();
        }else{
            return false;
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

    $('#expirationEnable').click(function(){
        if($(this).is(':checked')) {
            $('#addSchedule').prop('checked', false);
            $('#editGeoLocation').prop('checked', false);
            $('#scheduleArea').hide();
            $('#geo-location-body').hide();
            $('#day1').val('');
            $('#day2').val('');
            $('#day3').val('');
            $('#day4').val('');
            $('#day5').val('');
            $('#day6').val('');
            $('#day7').val('');
            /* empty special schedule */
            var splCount = $('#special_url_count').val();
            if(splCount>0){
                var countRow = 1;
                for(var i=1; i<splCount; i++){
                    $('#special_url-'+countRow).remove();
                    countRow = parseInt(countRow)+1;
                }
            }
            $('#schedule_datepicker_0').val('');
            $('#scd_id_0').val('');
            $('#special_url_0').val('');
        }
    });

    $('#addSchedule').click(function(){
        if($(this).is(':checked')){
            $('#expirationEnable').prop('checked', false);
            $('#editGeoLocation').prop('checked', false);
            $('#expirationArea').hide();
            $('#geo-location-body').hide();
            $('#datepicker').val('month/day/year hours:minutes AM/PM');
            $('#expirationTZ').val('');
            $('#expirationUrl').val('');
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

    var rowCount = $('#db_spl_url_count').val();

    if(rowCount > 0){
        for(var i=0; i<rowCount; i++){
            $("#schedule_datepicker_"+i).kendoDatePicker({
                value: '',
                min: new Date(),
                dateInput: false
            });

            $('#schedule_datepicker_'+i).bind('change', function(){
                var actualId =  $(this).prop('id');
                var numId = actualId.replace('schedule_datepicker_', '');
                numId = numId.trim();
                var new_count = $("#special_url_count").val();
                if(new_count>0){
                    for(var j=0; j <new_count; j++){
                        if($('#schedule_datepicker_'+j).length>0 && $(this).val() == $('#schedule_datepicker_'+j).val() && numId!=j){
                            swal("Sorry!", "Date already given as schedule please pick another one", "warning");
                            $('#schedule_datepicker_'+numId).val('');
                            $('#scd_id_'+numId).val('');
                            break;
                        }
                        else{
                            $('#scd_id_'+numId).val($(this).val());
                        }
                    }
                }
            });
        }
    }else if(rowCount==0){
        $("#schedule_datepicker_0").kendoDatePicker({
            value: '',
            min: new Date(),
            dateInput: false
        });
        $('#schedule_datepicker_0').bind('change', function(){
            $('#scd_id_0').val($(this).val())
        });
    }

    function drawRegionsAllowMap() {
        var values = [];
        $("input[name='denyCountryName[]']").each(function() {
            values.push($(this).val());
        });

        var action = [];
        $("input[name='denied[]']").each(function() {
            action.push($(this).val());
        });

        var redirect = [];
        $("input[name='redirect[]']").each(function() {
            redirect.push($(this).val());
        });
        $.ajax({
            type: 'post',
            url: "/getDenyCountryInAllowAll",
            data: {data:values, action:action, redirect:redirect, _token: '{{csrf_token()}}'},
            success: function (response) {
                if(response.code=200){
                    var arr = Object.values(response.data);
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Country');
                    data.addColumn('number', 'Status');
                    // A column for custom tooltip content
                    data.addColumn({type: 'string', role: 'tooltip'});
                    data.addRows(arr);
                    var options = {
                        backgroundColor: '#FFFF',
                        defaultColor: '#95D981',
                        width   : '100%',
                        hight   : '100%',
                        keepAspectRatio: false,
                        margin  : 15,
                        border  : 15,
                        legend  : 'none',
                        marginColor : 'black',
                        //colorAxis: {colors: ['#EC6B69','#95D981']},
                        colorAxis: {
                            values:[0, 1, 2],
                            colors:['#EC6B69', '#95D981','#00BFFF']
                        }
                    };
                    var chart = new google.visualization.GeoChart(document.getElementById('map-div'));
                    chart.draw(data, options);
                    google.visualization.events.addListener(chart, 'select', selectHandler);

                    function selectHandler() {
                        if(chart.getSelection().length >0){
                            var selectionIdx = chart.getSelection()[0].row;
                            var countryName = data.getValue(selectionIdx, 0);
                            if (countryName) {
                                if (countryName) {
                                    if($("#" + countryName).length == 0) {
                                        $.ajax({
                                            type: 'post',
                                            url: "/getCountryDetails",
                                            data: {_token: '{{csrf_token()}}',countryName:countryName},
                                            success: function (response) {
                                                //console.log(response)
                                                if(response.status_code==200){
                                                    $('#denied-country-name').html(response.data.name);
                                                    $('#deny-country-code').val(response.data.code);
                                                    $('#deny-country-id').val(response.data.id);
                                                    $('#deny-country').prop('checked', false);
                                                    $('#redirect-country').prop('checked', false);
                                                    $('#redirect-url').hide();
                                                    $('#redirect-url').val("");
                                                    $('#deny-country-modal').modal('show');
                                                }
                                            }
                                        });
                                    }else{
                                        $("#"+countryName).remove();
                                        google.charts.setOnLoadCallback(drawRegionsAllowMap);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        });
    };

    $('#deny-the-country').click(function(){
        var countryName=$('#denied-country-name').text().trim();
        var countryCode=$('#deny-country-code').val().trim();
        var countryId=$('#deny-country-id').val().trim();
        if(countryName && countryCode && countryId){
            if($("#deny-country").is(':checked')){
                var deny="<div id='"+countryName+"'><input type='hidden' name='denyCountryName[]' value='"+countryName+"'>"+
                            "<input type='hidden' name='denyCountryCode[]' value='"+countryCode+"'>"+
                            "<input type='hidden' name='denyCountryId[]' value='"+countryId+"'>"+
                            "<input type='hidden' name='allowed[]' value='0'>"+
                            "<input type='hidden' name='denied[]' value='1'>"+
                            "<input type='hidden' name='redirect[]' value='0'>"+
                            "<input type='hidden' name='redirectUrl[]' value=''>"+
                        "</div>";
                $('#denied-country').append(deny);
                $('#deny-country-modal').modal('hide');
                google.charts.setOnLoadCallback(drawRegionsAllowMap);
            }else if($("#redirect-country").is(':checked')){
                var redirectUrl=$('#redirect-url').val();
                if(!redirectUrl){
                    swal("Alert", "Please Provide A Redirect Url");
                }else{
                    var checkUrl=ValidURL(redirectUrl);
                    if(checkUrl){
                        var deny="<div id='"+countryName+"'><input type='hidden' name='denyCountryName[]' value='"+countryName+"'>"+
                                    "<input type='hidden' name='denyCountryCode[]' value='"+countryCode+"'>"+
                                    "<input type='hidden' name='denyCountryId[]' value='"+countryId+"'>"+
                                    "<input type='hidden' name='allowed[]' value='0'>"+
                                    "<input type='hidden' name='denied[]' value='0'>"+
                                    "<input type='hidden' name='redirect[]' value='1'>"+
                                    "<input type='hidden' name='redirectUrl[]' value='"+redirectUrl+"'>"+
                                "</div>";
                        $('#denied-country').append(deny);
                        $('#deny-country-modal').modal('hide');
                        google.charts.setOnLoadCallback(drawRegionsAllowMap);
                    }else{
                        return false;
                    }
                }
            }else{
                swal("Alert", "Nothing To Save");
            }
        }else{
           swal("Something Wrong", "Try Again!");
        }
    });

    $('#allow-the-country').click(function(){
        var countryName=$('#allowed-country-name').text().trim();
        var countryCode=$('#allowed-country-code').val().trim();
        var countryId=$('#allowed-country-id').val().trim();
        if(countryName && countryCode && countryId){
            if($("#allow-country").is(':checked')){
                var deny="<div id='"+countryName+"'><input type='hidden' name='denyCountryName[]' value='"+countryName+"'>"+
                            "<input type='hidden' name='denyCountryCode[]' value='"+countryCode+"'>"+
                            "<input type='hidden' name='denyCountryId[]' value='"+countryId+"'>"+
                            "<input type='hidden' name='allowed[]' value='1'>"+
                            "<input type='hidden' name='denied[]' value='0'>"+
                            "<input type='hidden' name='redirect[]' value='0'>"+
                            "<input type='hidden' name='redirectUrl[]' value=''>"+
                        "</div>";
                $('#allowable-country').append(deny);
                $('#allow-country-modal').modal('hide')
                google.charts.setOnLoadCallback(drawRegionsDenyMap);
            }
            else if($("#allow-redirect-url-checkbox").is(':checked')){
                var redirectUrl=$('#redirect-url-allow').val();
                if(!redirectUrl){
                    swal("Alert", "Please Provide A Redirect Url");
                }else{
                    var checkUrl=ValidURL(redirectUrl);
                    if(checkUrl){

                        var deny="<div id='"+countryName+"'><input type='hidden' name='denyCountryName[]' value='"+countryName+"'>"+
                                    "<input type='hidden' name='denyCountryCode[]' value='"+countryCode+"'>"+
                                    "<input type='hidden' name='denyCountryId[]' value='"+countryId+"'>"+
                                    "<input type='hidden' name='allowed[]' value='0'>"+
                                    "<input type='hidden' name='denied[]' value='0'>"+
                                    "<input type='hidden' name='redirect[]' value='1'>"+
                                    "<input type='hidden' name='redirectUrl[]' value='"+redirectUrl+"'>"+
                                "</div>";
                        $('#allowable-country').append(deny);
                        $('#allow-country-modal').modal('hide')
                        google.charts.setOnLoadCallback(drawRegionsDenyMap);
                    }else{
                        return false;
                    }
                }

            }else{
                swal("Alert", "Nothing To Save");
            }
        }else{
           swal("Something Wrong", "Try Again!");
        }
    });

    $('#allow-redirect-url-checkbox').click(function(){
        if($(this).is(":checked")) {
            $('#allow-country').prop('checked', false);
            $('#redirect-url-allow').css('display', 'block');
            $('#redirect-url-allow').focus();
        }else{
            $('#redirect-url-allow').css('display', 'none');
        }
    });

    $('#allow-country').click(function(){
        if($(this).is(":checked")) {
            $('#allow-redirect-url-checkbox').prop('checked', false);
            $('#redirect-url-allow').css('display', 'none');
        }
    });

    $('#redirect-country').click(function(){
        if($(this).is(":checked")) {
            $('#deny-country').prop('checked', false);
            $('#redirect-url').css('display', 'block');
            $('#redirect-url').focus();
        }else{
            $('#redirect-url').css('display', 'none');
        }
    });

    $('#deny-country').click(function(){
        if($(this).is(":checked")) {
            $('#redirect-country').prop('checked', false);
            $('#redirect-url').css('display', 'none');
        }
    });
});


function checkUrl(urlVal){
    if(urlVal.length>0){
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!-\/]))?/;
        if(!pattern.test(urlVal)){
            swal({
                type: 'error',
                title: 'Invalid URL!',
                text: 'Text given instead of an URL',
            })
        }else{
            var urlCount = urlVal.split(":");
            if(urlCount.length!=2){
                swal({
                    type: 'error',
                    title: 'Invalid URL!',
                    text: 'Text given instead of an URL',
                });
            }
        }
    }
}

/* Add more tab for special schedules */
function dispButton(id){
    if(id>0){
        $('#add_button_'+id).hide();
        $('#delete_button_'+id).show();
    }
}

/* Delete special day tab */
function delTabRow(indx){
    $('#special_url-'+indx).remove();
}


function drawRegionsDenyMap() {
    var values = [];
    $("input[name='denyCountryName[]']").each(function() {
        values.push($(this).val());
    });

    var action = [];
    $("input[name='allowed[]']").each(function() {
        action.push($(this).val());
    });

    var redirect = [];
    $("input[name='redirect[]']").each(function() {
        redirect.push($(this).val());
    });
    $.ajax({
        type: 'post',
        url: "/getDenyCountryInAllowAll",
        data: {data: values, action:action, redirect:redirect, _token: '{{csrf_token()}}'},
        success: function (response) {
            console.log(response);
            if(response.code=200){
                var arr = Object.values(response.data);
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Country');
                data.addColumn('number', 'Status');
                // A column for custom tooltip content
                data.addColumn({type: 'string', role: 'tooltip'});
                data.addRows(arr);
                var options = {
                    backgroundColor: '#FFFF',
                    defaultColor: '#EC6B69',
                    width   : '100%',
                    hight   : '100%',
                    keepAspectRatio: false,
                    margin  : 15,
                    border  : 15,
                    legend: 'none',
                    marginColor : 'black',
                    colorAxis: {
                        values:[0, 1, 2],
                        colors:['#95D981', '#EC6B69','#00BFFF']
                    }
                };
                var chart = new google.visualization.GeoChart(document.getElementById('map-div'));
                chart.draw(data, options);
                google.visualization.events.addListener(chart, 'select', selectHandler);

                function selectHandler() {
                    if(chart.getSelection().length >0){
                        var selectionIdx = chart.getSelection()[0].row;
                        var countryName = data.getValue(selectionIdx, 0);
                        if (countryName) {
                            if($("#" + countryName).length == 0) {
                                $.ajax({
                                    type: 'post',
                                    url: "/getCountryDetails",
                                    data: {_token: '{{csrf_token()}}',countryName:countryName},
                                    success: function (response) {
                                    //console.log(response)
                                        if(response.status_code==200){
                                            $('#allowed-country-name').html(response.data.name);
                                            $('#allowed-country-code').val(response.data.code);
                                            $('#allowed-country-id').val(response.data.id);
                                            $('#allow-country').prop('checked', false);
                                            $('#allow-redirect-url-checkbox').prop('checked', false);
                                            $('#redirect-url-allow').val();
                                            $('#redirect-url-allow').hide();
                                            $('#allow-country-modal').modal('show');
                                        }

                                    }
                                });
                            }else{
                                $("#"+countryName).remove();
                                google.charts.setOnLoadCallback(drawRegionsDenyMap);
                            }
                        }
                    }
                }
            }
        }
    });
}
