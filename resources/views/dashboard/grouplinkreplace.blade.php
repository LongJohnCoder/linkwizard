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
	{{$grouplink->links()}}
</div>