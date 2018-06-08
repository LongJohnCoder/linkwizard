$(document).ready(function () {
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
				'				class="form-control" placeholder="Please Provide A Valied Url Like http://www.example.com">\n' +
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

    $(".chosen-select").chosen({});
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

    $('#edit-short-url').click(function(event){
        event.preventDefault();
        var getUrlType=$('#type').val();
        if(getUrlType==0){
            var originalUrl=$('#givenActual_Url').val().trim();
            if(!originalUrl){
                swal({
                    title: "Error",
                    text: "Need a Actual URL to create a short Url",
                    type: "error",
                    html: true
                });
                return false;
            }else{
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
        }else{
            return false;
        }

        if($("#checkboxAddFbPixelid").prop('checked') == true){
            alert('True');
        }else{
            alert("False");
        }
        // $("#url_short_frm").submit();
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
});

