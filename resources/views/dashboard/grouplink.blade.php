@extends('layout/layout')
@section('content')
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script> -->
    <div class="main-dashboard-body">
        <section class="main-content">
            <div class="container">
            	<div class="row">
	                <div class="col-md-12 col-sm-12 col-lg-12">
		                <div class="panel panel-default">
	    					<div class="panel-body row">
	    						<div class="col-md-6 col-sm-6 col-lg-6">
	    							<label>Group Link</label>
	    						</div>
	    						<div class="col-md-6 col-sm-6 col-lg-6">
	    							<button type="button" class="btn-success btn-md pull-right" data-toggle="modal" data-target="#myModal"><i class='fa fa-plus'></i>Add Group Link</button>
	    						</div>
	    					</div>
	  					</div>
	                </div>
	            </div>
	            <div class="row" id="show-all-grouplink">
	                <div class="col-md-12 col-sm-12 col-lg-12">
	                <table  class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
				             	<th>Title</th>
				                <th>Group Url</th>
				                <th>Total Link</th>
				                <th>Creation Date</th>
				                <th>Action</th>
				            </tr>
				        </thead>
				        <tbody>
				        @if(count($grouplink)>0)
				        	@foreach($grouplink as $grouplinks)
				        		<tr>
				        			<td>{{$grouplinks->title}}</td>
				        			<td>{{$grouplinks->shorten_suffix}}</td>
				        			<td></td>
				        			<td>{{date_format($grouplinks->created_at,"d M,Y H:i")}}</td>
				        			<td></td>
				        		</tr>
				        	@endforeach
				        @else
				        	<h2>No Group Link Available</h2>
				        @endif	
				        </tbody>
				    </table>
	               	</div>
	               	<div class="col-md-12 col-sm-12 col-lg-12">
	               		{{ $grouplink->render() }}
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
            </div>
        </section>
    </div>
    
    <script type="text/javascript">
    	$(document).ready(function(){
    		/*$('#example').DataTable();*/
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
	                			$('.close').click();
	                			$('#show-all-grouplink').html(response.allGroupLink);
	                			swal({
	                                title: "Success",
	                                text: "Group Link Generated Successfully!",
	                                type: "success",
	                            });
	                		}
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
