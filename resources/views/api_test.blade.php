<!DOCTYPE html>
<html>
<head>
	<title>tr5.io | api</title>
</head>
<script src="{{url('/')}}/public/js/jquery.min.js"></script>
<body>

<form action="{{url('/')}}/short_url_api">
	<label>Give url : </label>
	<input type="text" id="url" name="url">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<button id="submit">Submit</button>
</form>

	<label>Shortend url :</label>
	<span id="short_url"></span>
</body>
<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>
</html>