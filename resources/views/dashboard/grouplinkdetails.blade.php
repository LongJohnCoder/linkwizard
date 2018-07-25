@extends('layout/layout')
@section('content')
	<style type="text/css">
		.details-group{
			padding: 10px;
		}
		
	</style>
    <div class="main-dashboard-body">
        <section class="main-content">
            <div class="container">
            	<div class="panel panel-primary">
                    <div class="panel-heading">
                    	<h4 >Group Details</h4>
                    </div>
                    <div class="panel-body">
                        <div class="text-center">
                        	<div class="bs-example">
							    <ul class="breadcrumb">
							        <li><a href="#">Group Link</a></li>
							        <li class="active">Group Details</li>
							    </ul>
							</div>
                        	<div class=" row">
	    						@php
		                            if(isset($getGroupDetails->subdomain)) {
		                                if($getGroupDetails->subdomain->type == 'subdomain')
		                                    $group_url = config('settings.SECURE_PROTOCOL').$getGroupDetails->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST').'/'.$getGroupDetails->shorten_suffix;
		                                else if($getGroupDetails->subdomain->type == 'subdirectory')
		                                    $group_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$getGroupDetails->subdomain->name.'/'.$getGroupDetails->shorten_suffix;
		                            } else {
		                                $group_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$getGroupDetails->shorten_suffix;
		                            }
		                        @endphp
	    						<div class="col-md-6 col-sm-6 col-lg-6 details-group">
	    							<b>Group Title</b>
	    						</div>
	    						<div class="col-md-6 col-sm-6 col-lg-6 details-group">
	    							{{$getGroupDetails->title}}
	    						</div>
	    						<div class="col-md-6 col-sm-6 col-lg-6 details-group">
	    							<b>Url</b>
	    						</div>
	    						<div class="col-md-6 col-sm-6 col-lg-6 details-group">
	    							{{$group_url}}
	    						</div>
    						</div>
                        	<div class="col-md-12 col-sm-12 col-lg-12 table-responsive">
    							<table  class="table table-striped table-bordered">
	    							<thead>
						             	<th>Title</th>
						                <th>Short Url</th>
						                <th>Destination Url</th>
						                <th>Action</th>
					        		</thead>
					        		<tbody>
								        @if(count($getSubLink)>0)
								        	@foreach($getSubLink as $grouplinks)
									        	@php
		                                        if(isset($grouplinks->subdomain)) {
		                                            if($grouplinks->subdomain->type == 'subdomain')
		                                                $shrt_url = config('settings.SECURE_PROTOCOL').$grouplinks->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST').'/'.$grouplinks->shorten_suffix;
		                                            else if($grouplinks->subdomain->type == 'subdirectory')
		                                                $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$grouplinks->subdomain->name.'/'.$grouplinks->shorten_suffix;
		                                        } else {
		                                            $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$grouplinks->shorten_suffix;
		                                        }
		                                    	@endphp
								        		<tr>
								        			<td>{{$getGroupDetails->title}}</td>
								        			<td>{{$shrt_url}}</td>
								        			<td>{{$grouplinks->protocol}}://{{$grouplinks->actual_url}}</td>
								        			<td><a class="btn-primary btn-xs " title="Link Info" href="{{route('getLinkPreview',[$grouplinks->id])}}" terget="_blank"><i class="fa fa-info"></i></a></td>
								        		</tr>
								        	@endforeach
								        @else
								        	<tr><td colspan="3">No Group Link Available<td></tr>
								        @endif	
								        </tbody>
    							</table>
    						</div>
    						<div class="col-md-12 col-sm-12 col-lg-12">
	               				{{ $getSubLink->render() }}
	               			</div>
                        </div>
                    </div>
                </div>

    					
    					
    					
	                </div>
	           
        </section>
    </div>
@stop
