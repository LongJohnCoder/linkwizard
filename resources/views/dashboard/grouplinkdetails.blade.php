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
                    	<div class="bs-example">
						    <ul class="breadcrumb">
						        <li><a href="#">Group Link</a></li>
						        <li class="active">Group Details</li>
						    </ul>
						</div>
                    	<div class=" row">
                    		<div class="col-md-12 col-sm-12 col-lg-12 table-responsive">
                        		<table  class="table table-bordered">
				        			<tbody>
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
						        		<tr>
						        			<td class="alert-success">Group Title</td>
						        			<td class="alert-info">{{$getGroupDetails->title}}</td>
						        		</tr>
						        		<tr>
						        			<td class="alert-success">Url</td>
						        			<td class="alert-info">{{$group_url}}</td>
						        		</tr>
							        </tbody>
    							</table>
							</div>
							@if(count($getSubLink)>0)
                    		<div class="col-md-12 col-sm-12 col-lg-12 table-responsive">
								<table  class="table table-striped table-bordered" id="show-all-groupedlink" >
    								<thead >
						             	<th>Title</th>
						                <th>Short Url</th>
						                <th>Destination Url</th>
						                <th>Action</th>
				        			</thead>
				        			<tbody>
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
							        			<td>
							        				<a class="btn-primary btn-xs" title="Link Info" href="{{route('getLinkPreview',[$grouplinks->id])}}" terget="_blank"><i class="fa fa-info"></i></a>
							        				<a class="btn-danger btn-xs delete-link" title="Delete Link" data-id="{{base64_encode($grouplinks->id)}}"><i class="fa fa-trash"></i></a>
							        			</td>
						        			</tr>
							        	@endforeach
							        </tbody>
								</table>
							</div>
	               			@else
	               			<div class="col-md-12 col-sm-12 col-lg-12">
								<h4>No Link Available For This Group</h4>
							</div>
							@endif		
                    	</div>
                	</div>		
	            </div>
	        </div>
        </section>
    </div>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('#show-all-groupedlink').DataTable();
    		$('.delete-link').click(function(){
    			var linkId=$(this).data("id");
   				swal({
                    title: "Are you sure you want to delete this link?",
                    text: "Once deleted, you will not be able to recover this short link again!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(){
                   	$.ajax({
			   			method:"post",
			   			url:"{{route('deleteGroupLink')}}",
			   			data:{ linkid:linkId, _token:"{{csrf_token()}}" },
			   			success: function(response){
			   				//console.log(response);
			   				if(response.status==true){
			   					swal({
									type: 'success',
									title: 'Success',
									text: 'Success! Your short link has been deleted!',
								});
						    	window.location.reload();
			   				}else{
			   					swal({
									type: 'error',
									title: 'Oops...',
									text: 'Something went wrong, Try Again!',
								});
			   				}
			   			}
					});
                });
    		});
    	});
    </script>
@stop
