
$(document).ready(function () {
    $('#addGeoLocation, #custom').prop('checked', false);
    $('#custom').attr("disabled", true);
    $('#geo-location-body').hide();
    $('#selected-country').hide();
    $('#show-selected-country').html();
    $('#addGeoLocation').click(function(){
        if (this.checked) {
            $('#geo-location-body').show();
        }else{
            $('#geo-location-body').hide();
        }
    });

    $('#custom').click(function(event){
        if($('#custom').is(':checked')==true){
            $('#selected-country').show();
        }else{
            $('#selected-country').hide();
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
                    if(chart.getSelection().length >0){
                        var selectionIdx = chart.getSelection()[0].row;
                        var countryName = data.getValue(selectionIdx, 0);
                        if (countryName) {
                            if(selectedContry.includes(countryName)==false){
                                selectedContry.push(countryName); 
                                $.ajax({
                                    type: 'post',
                                    url: "/getCountryDetails",
                                    data: {_token: '{{csrf_token()}}',countryName:countryName},
                                    success: function (response) {
                                        $('#show-selected-country').append(response);
                                    }
                                });
                                if(selectedContry.length >0){
                                    $('#custom').removeAttr("disabled");
                                }
                            }
                        }
                    }
                }
        	}
		}
	});
}


