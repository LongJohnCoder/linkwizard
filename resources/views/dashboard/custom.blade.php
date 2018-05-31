<div class="row" id="selected-country-row{{$selectedCountry['id']}}">	
	<div class="col-md-2">
		{{$selectedCountry['name']}}
	</div>
	<div class="col-md-2">
		<input type="radio" name="custom-settings[{{$selectedCountry['id']}}]" value="0" checked> Allow
	</div>
	<div class="col-md-2">
		<input type="radio" name="custom-settings[{{$selectedCountry['id']}}]" value="1"> Deny
	</div>
	<div class="col-md-2">
		<input type="radio" name="custom-settings[{{$selectedCountry['id']}}]" value="2"> Redict
	</div>
	<div class="col-md-4 form-group" id="redirect-url-{{$selectedCountry['id']}}" >
		<input type="text" name="redirect-url[{{$selectedCountry['id']}}]" class="form-control" placeholder="Redirect Url">
	</div>
</div>