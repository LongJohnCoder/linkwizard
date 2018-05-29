
$(document).ready(function () {
    $('#addGeoLocation, #allow-country, #allow-set-url, .allow-country-select').prop('checked', false);
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
                       //console.log(response);
                       $('#after-allow-select').show();
                       var SelectedCountryView="";
                       for($i=0; $i < response.data.length; $i++){
                            SelectedCountryView+="<li class='col-md-12 row'><div class='col-md-2 form-group'><input type='checkbox' class='allow-country-select' checked></div><div class='col-md-4 form-group'> "+response.data[$i]['name']+"</div><div class='col-md-6 form-group'><input type='text' class='form-control' placeholder='Please Provide Redirect Url'></li></div>";
                       }
                       $('#selected-country-view').html(SelectedCountryView);
                    }
                });
            }else{
                event.preventDefault();
                swal(
                    'No Contry Selected',
                    'Please select the country first!',
                    'warning'
                )
            }
        }else{
            $('#after-allow-select').hide();
        }
        //console.log(selectedContry);
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
                console.log(response.data);
        		var data = google.visualization.arrayToDataTable(response.data);
				var options = {
					width   : '100%',
				};
				var chart = new google.visualization.GeoChart(document.getElementById('map-div'));
				chart.draw(data, options);
                google.visualization.events.addListener(chart, 'select', selectHandler);

                function selectHandler() {
                    var selectedItem = chart.getSelection()[0];
                    if (selectedItem) {
                        var countryId=parseInt(selectedItem.row)+1;
                        if(selectedContry.includes(countryId)==false){
                            selectedContry.push(countryId); 
                        }
                    }
                    console.log(selectedContry);
                }
        	}
		}
	});
}


