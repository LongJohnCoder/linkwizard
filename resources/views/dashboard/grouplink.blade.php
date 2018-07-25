@extends('layout/layout')
@section('content')
    <div class="main-dashboard-body">
        <section class="main-content">
            <div class="container">
            	<div class="panel panel-primary">
                    <div class="panel-heading">
                    	<h4 >Group Link</h4>
                    </div>
                    <div class="panel-body">
                        <div class="text-center">
                        	<div class="bs-example">
							    <ul class="breadcrumb">
							        <li class="active">Group Link</li>
							    </ul>
							</div>
                        	<div class="table-responsive">
                                <sapn class="pull-left">
                                    <button class="btn btn-xs btn-primary" id="show-creat-grouplink"><i class='fa fa-plus'></i>Add Group Link</button>
                                </sapn>
                                <!-- Responsive data table -->
								<table id="show-all-grouplink" class="table table-hover pixel-table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
							                <th>Group Url</th>
							                <th>Total Sub-link</th>
							                <th>Creation Date(UTC Time)</th>
							                <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($grouplink)>0)
									       	@foreach($grouplink as $grouplinks)
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
						        			<td>{{$grouplinks->title}}</td>
						        			<td>{{$shrt_url}}</td>
						        			<td>{{count($grouplinks->children)}}</td>
						        			<td>{{date_format($grouplinks->created_at,"d M, Y H:i a")}}</td>
						        			<td>
									        	<a class="btn-primary btn-xs action-btn" title="Group Info" href="{{route('show-group-details', base64_encode($grouplinks->id))}}" terget="_blank"><i class="fa fa-info"></i></a>
									        </td>
									    </tr>
									    @endforeach
								        @else
								        	<tr><td colspan="4">No Group Link Available<td></tr>
								        @endif	
                                   	</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
               
	               
	            <!-- Modal -->
				<div id="myModal" class="modal fade" role="dialog">
				  	<div class="modal-dialog modal-md">
				    	<!-- Modal content-->
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<button type="button" class="close" data-dismiss="modal">&times;</button>
				      		</div>
				      		<div class="modal-body">
				      			<div class="form-group">
				      				<center><b><h3>Add Group Link</h3></b></center>
				      			</div>
								<div class="form-group">
									<input type="text" name="group-link-title" id="group-link-title" class="form-control" placeholder="Enter Group Url Title">
								</div>
								<div class="form-group">
									<button class='btn-success btn-md form-control' id="create-new-grouplink">Save</button>
								</div>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<!-- Modal -->
            </div>
        </section>
    </div>
    
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('#show-all-grouplink').DataTable();
    		$('#show-creat-grouplink').click(function(){
    			$('#myModal').modal('show');
    		});
    		$('#create-new-grouplink').click(function(){
    			var linktitle=$('#group-link-title').val().trim();
    			if(linktitle){
	    			$.ajax({
	    				type: "POST",
	                	url: "{{route('createsingleGroupLink')}}",
	                	data: {linktitle:linktitle,_token: '{{csrf_token()}}'},
	                	success: function (response) {
	                		console.log(response);
	                		if(response.code==200){
	                			$('#myModal').modal('hide');
	                			swal({
	                                title: "Success",
	                                text: "Group Link Generated Successfully!",
	                                type: "success",
	                            });
	                		}

	                		setTimeout(function(){
   								window.location.reload();
							}, 3000);
	                	}
	    			});
    			}else{
    				swal({
                        title: "Error",
                        text: "Please provide link title!",
                        type: "error",
                    });
    			}
    		});
    	});
    </script>
@stop
