$(document).ready(function () {
    $('#addGeoLocation, #custom').prop('checked', false);
    $('#custom').attr("disabled", true);
    $('#geo-location-body').hide();
    $('#selected-country').hide();
    $('#show-selected-country').html();
    $('#addGeoLocation').click(function(){
        if (this.checked) {
            $('#expirationEnable').prop('checked', false);
            $('#addSchedule').prop('checked', false);
            $('#expirationArea').hide();
            $('#scheduleArea').hide();

            $('#geo-location-body').show();
            if($("#allow-all").is(':checked')){
                google.charts.setOnLoadCallback(drawRegionsMap);
            }
            if($("#deny-all").is(':checked')){
                google.charts.setOnLoadCallback(drawRegionsDenyMap);
            }
        }else{
            $('#geo-location-body').hide();
        }
    });

    $('#deny-country').change(function() {
        if($(this).is(":checked")) {
            $('#redirect-country').prop('checked', false);
            $('#redirect-url').hide();
        }
    });

    $('#redirect-country').change(function() {
        if($(this).is(":checked")) {
            $('#deny-country').prop('checked', false);
            $('#redirect-url').show();
        }else{
            $('#redirect-url').hide();
        }
    });

    $('#allow-all').change(function() {
        if($(this).is(":checked")) {
            $('#deny-all').prop('checked', false);
            $('#allowable-country').html("");
            $('#denied-country').html("");
            google.charts.setOnLoadCallback(drawRegionsMap);
        }else{
            $('#deny-all').prop('checked', true);
            $('#allowable-country').html("");
            $('#denied-country').html("");
            google.charts.setOnLoadCallback(drawRegionsDenyMap);
        }   
    });

    $('#deny-all').change(function() {
        if($(this).is(":checked")) {
            $('#allow-all').prop('checked', false);
             $('#allowable-country').html("");
            $('#denied-country').html("");
             google.charts.setOnLoadCallback(drawRegionsDenyMap);
        }else{
            $('#allow-all').prop('checked', true);
             $('#allowable-country').html("");
            $('#denied-country').html("");
            google.charts.setOnLoadCallback(drawRegionsMap);
        }   
    });

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
                google.charts.setOnLoadCallback(drawRegionsMap);
            }else if($("#redirect-country").is(':checked')){
                var redirectUrl=$('#redirect-url').val();
                if(!redirectUrl){
                    swal("Alert", "Please Provide A Redirect Url");
                }else{
                    var checkUrl=ValidURL(redirectUrl);
                    if(!checkUrl){
                        swal("Alert", "Please Provide A Valid Redirect Url");
                    }else{
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
                        $('#redirect-url').val(" ");
                        google.charts.setOnLoadCallback(drawRegionsMap);
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
                    $('#allow-country-modal').modal('hide');
                    google.charts.setOnLoadCallback(drawRegionsDenyMap); 
                }else if($("#allow-redirect-url-checkbox").is(':checked')){
                    var url=$('#redirect-url-allow').val().trim();
                    var checkUrl=ValidURL(url);
                    if(!checkUrl){
                       swal("Alert", "You Need To Provide Some Redirect URL!");
                    }else{
                       var deny="<div id='"+countryName+"'><input type='hidden' name='denyCountryName[]' value='"+countryName+"'>"+
                            "<input type='hidden' name='denyCountryCode[]' value='"+countryCode+"'>"+
                            "<input type='hidden' name='denyCountryId[]' value='"+countryId+"'>"+
                            "<input type='hidden' name='allowed[]' value='0'>"+
                            "<input type='hidden' name='denied[]' value='0'>"+
                            "<input type='hidden' name='redirect[]' value='1'>"+
                            "<input type='hidden' name='redirectUrl[]' value='"+url+"'>"+
                        "</div>";
                        $('#allowable-country').append(deny);
                        $('#allow-country-modal').modal('hide');
                        $('#redirect-url-allow').val("");
                        google.charts.setOnLoadCallback(drawRegionsDenyMap); 
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
            $('#redirect-url-allow').val('');
            $('#redirect-url-allow').css('display', 'none');
        }  
    });
    $('#allow-country').click(function(){
        if($(this).is(":checked")) {
            $('#allow-redirect-url-checkbox').prop('checked', false);
            $('#redirect-url-allow').val('');
            $('#redirect-url-allow').hide('');
        }
    });
});

var selectedContry=new Array();
var getselectedContry=new Array();

google.charts.load('current', {
    'packages':['geochart'],
    'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
});

function drawRegionsMap() {
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
                    legend: 'none',
                    marginColor : 'black',
                    /*colorAxis: {colors: ['#EC6B69','#95D981']},*/
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
                                            $('#deny-country-modal').modal('show');
                                        }
                                    }
                                });
                            }else{
                                $("#"+countryName).remove();
                                google.charts.setOnLoadCallback(drawRegionsMap);
                            }
                        }
                    }
                }
            }
        }
    });
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
                    defaultColor: '#EC6B69', 
                    width   : '100%',
                    hight   : '100%',
                    keepAspectRatio: false,
                    margin  : 15,
                    border  : 15,
                    legend: 'none',
                    marginColor : 'black',
                    //colorAxis: {colors: ['#95D981','#EC6B69']},
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

