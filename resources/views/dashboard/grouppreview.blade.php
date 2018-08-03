@extends('layout/layout')
@section('content')
	<!-- Header End -->
	<div class="main-dashboard-body">
	 	<div class="main-content">
	    	<div class="container">
	      		<div class="row">
	        		<div class="col-md-12 col-sm-12">
              			<div class="panel panel-primary">
              				<div class="panel-heading">
	                  			<h4> Group Details</h4>
          					</div>
      						<div class="row">
			                  	<div class="col-md-12">
			                  		<div class="row">
			            				<div class="col-md-2 col-sm-2">
			            					<strong>Group</strong>
			            				</div>
		                  				<div class="col-md-10 col-sm-10">
		                  					@php
							                if(isset($url->subdomain)) {
							                  if($url->subdomain->type == 'subdomain')
							                      $shrt_url = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
							                  else if($url->subdomain->type == 'subdirectory')
							                      $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
							                } else {
							                  $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
							                }
							              @endphp
							              {{$shrt_url}}
		                  				</div>
	                  				</div>
		                  			<div class="row">
		                  				<div class="col-md-2 col-sm-2">
			            					<strong>Group Name</strong>
			            				</div>
		                  				<div class="col-md-10 col-sm-10">
		                  					{{$url->title}}
		                  				</div>
		                  			</div>
			                      	<div class="table-responsive">
			                          	<table class="table table-striped table-condensed show-info-tab">
			                              	<thead>
				                                <tr>
				                                    <th>#</th>
				                                    <th>Short Link</th>
				                                    <th>Long Link</th>
				                                    <th>Count</th>
				                                </tr>
			                              	</thead>
                          					<tbody>
                          					</tbody>
                      					</table>
                  					</div>
              					</div>
          					</div>
      					</div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
@stop
