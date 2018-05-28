
$(document).ready(function () {
	$('#addGeoLocation').click(function(){
		if (this.checked) {
            $('#geo-location-body').show();
        }else{
            $('#geo-location-body').hide();
        }
	});

    $('#allow-country').click(function(event){
        event.preventDefault();
        if(selectedContry.length >0){
            $.ajax({
                type: 'post',
                url: "/getSelectedCountryDetails",
                data: {_token: '{{csrf_token()}}',selectedContry:selectedContry},
                success: function (response) {
                    //var showSelected;
                    //console.log(response);]
                   /* if((response.data.length)>0){
                        foreach(response.data as data){
                            //var showSelected+="<div class='col-md-2'><input type='checkbox'></div><div class='col-md-8'></div><div class='col-md-2'></div>";
                        }
                    }*/
                    $('#allowModal').modal('show');
                }
            });
        }else{
            swal(
                'No Contry Selected',
                'Please select the country first!',
                'warning'
            )
        }
        //console.log(selectedContry);
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


