
$(document).ready(function () {
    $('#addGeoLocation, #allow-country, #allow-set-url, #block-country, .allow-country-select').prop('checked', false);
     $("#allow-country , #block-country").attr("disabled", true);
	$('#addGeoLocation').click(function(){
		if (this.checked) {
            $('#geo-location-body').show();
        }else{
            $('#geo-location-body').hide();
        }
	});

    $('#allow-country').click(function(event){
        if($('#allow-country').is(':checked')==true){
            if(selectedContry.length >0){
                $.ajax({
                    type: 'post',
                    url: "/getSelectedCountryDetails",
                    data: {_token: '{{csrf_token()}}',selectedContry:selectedContry},
                    success: function (response) {
                       console.log(response);
                       var SelectedCountryView="";
                       for($i=0; $i < response.data.length; $i++){
                            SelectedCountryView+="<li class='col-md-12 row'><div class='col-md-2 form-group'><input type='checkbox' class='allow-country-select' checked readonly></div><div class='col-md-4 form-group'> "+response.data[$i]['name']+"</div><div class='col-md-6 form-group'><input type='text' class='form-control' placeholder='Please Provide Redirect Url'></div></li>";
                       }
                       $('#selected-country-view').html(SelectedCountryView);
                       $('#after-allow-select').show();
                    }
                });
                $("#block-country").attr("disabled", true);
            }else{
                event.preventDefault();
                swal(
                    'No Country Selected',
                    'Please select the country first!',
                    'warning'
                )
            }
        }else{
            $('#after-allow-select').hide();
            $("#block-country").removeAttr("disabled");
        }
        //console.log(selectedContry);
    });

    $('#block-country').click(function(event){
        if($('#block-country').is(':checked')==true){
            if(selectedContry.length >0){
                $.ajax({
                    type: 'post',
                    url: "/getSelectedCountryDetails",
                    data: {_token: '{{csrf_token()}}',selectedContry:selectedContry},
                    success: function (response) {
                       var SelectedCountryView="";
                       for($i=0; $i < response.data.length; $i++){
                            SelectedCountryView+="<li class='col-md-12 row'><div class='col-md-2 form-group'><input type='checkbox' class='allow-country-select' checked readonly></div><div class='col-md-10 form-group'> "+response.data[$i]['name']+"</div></li>";
                       }
                       $('#blocked-country-view').html(SelectedCountryView);
                       $('#blocked-country-view').show();
                    }
                });
            }else{
                event.preventDefault();
                swal(
                    'No Country Selected',
                    'Please select the country first!',
                    'warning'
                )
            }
             $("#allow-country").attr("disabled", true);
        }else{
            $('#blocked-country-view').hide();
            $("#allow-country").removeAttr("disabled");
        }
    });

    $('#allow-set-url').click(function(event){
        if($('#allow-set-url').is(':checked')==true){
            $('#selected-country-view').show();
        }else{
            $('#selected-country-view').hide();
        }
    });
    
});

var selectedContry=new Array();

 

google.charts.load('current', {
    'packages':['geochart'],
    // Note: you will need to get a mapsApiKey for your project.
    // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
    'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
});
google.charts.setOnLoadCallback(drawRegionsMap);

function drawRegionsMap() {
    $.ajax({
		type: 'post',
        url: "/getallcountry",
        data: {_token: '{{csrf_token()}}'},
        success: function (response) {
        	if(response.code=200){
        		var data = google.visualization.arrayToDataTable(response.data);
				var options = {
                    backgroundColor: '#AFEEEE',
                    defaultColor: '#f5f5f5',
					width   : '100%',
                    margin  : 15,
                    border  : 15,
                    marginColor : 'black'
				};
				var chart = new google.visualization.GeoChart(document.getElementById('map-div'));
				chart.draw(data, options);
                google.visualization.events.addListener(chart, 'select', selectHandler);

                function selectHandler() {
                    var selectionIdx = chart.getSelection()[0].row;
                    var countryName = data.getValue(selectionIdx, 0);
                    if (countryName) {
                        if(selectedContry.includes(countryName)==false){
                            selectedContry.push(countryName); 
                        }
                    }
                    if(selectedContry.length>0){
                        $("#allow-country, #block-country").removeAttr("disabled");
                    }
                }
        	}
		}
	});
}


