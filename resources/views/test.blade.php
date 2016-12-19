<!DOCTYPE html>
<html>
<head>
	<title>test</title>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<input type="text" name="url" id="a">
<button id="b">check</button>
<script type="text/javascript">
$(document).ready(function() {
	$("#b").click(function(){
		var u = $("#a").val();
		$.ajax({
			type:"post",
			url :"/test",
			data: {_token:'{{csrf_token()}}' , url:u},
			success: function(response){
				console.log('success');
				console.log(response);
			},
			error: function(response){
				console.log('error');
				console.log(response);
			}
		});
	});
});
</script>
</body>
</html>