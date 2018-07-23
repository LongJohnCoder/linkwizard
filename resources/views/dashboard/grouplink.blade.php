@extends('layout/layout')
@section('content')
    <div class="main-dashboard-body">
        <section class="main-content">
            <div class="container">
            	<div class="row">
	                <div class="col-md-12 col-sm-12">
                        <div class="normal-box row">
                           	<div class="col-md-12 col-sm-12">
                           		<label class="pull-left">Create Group Link</label>
                           	</div>
                           	<div class="col-md-12 col-sm-12">
                           		<button class='btn-success btn-md pull-left' id="create-new-grouplink">Create</button>
                           	</div>
                           	<div class="col-md-4 col-sm-4 pull-right">
                       
                        
                               
                           	</div>
                           	<div class="col-md-6 col-sm-6 pull-left" id="show-created-link">
                           		
                           	</div>
                        </div>
	                </div>
	            </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('#create-new-grouplink').click(function(){
    			$.ajax({
    				type: "POST",
                	url: "{{route('createsingleGroupLink')}}",
                	data: {_token: '{{csrf_token()}}'},
                	success: function (response) {
                		console.log(response);
                		if(response.code==200){
                			swal({
                                title: "Success",
                                text: "Group Link Generated Successfully!",
                                type: "success",
                            });
                            $('#show-created-link').html(response.link);
                		}
                	}
    			});
    		});
    	});
    </script>
@stop
