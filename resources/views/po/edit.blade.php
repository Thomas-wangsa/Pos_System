@extends('layouts.main')

@section('content')
<style type="text/css">
</style>
	

	<div style="margin: 10px auto">
	    <a href="{{route('po.index')}}">
	      <button type="button" class="btn btn-md btn-warning">
	        <span class="glyphicon glyphicon-chevron-left "></span>
	        Back
	      </button>
	    </a>
  	</div>

	<div class="main_section">	
		
		<form action="{{route('po.store')}}" method="POST">
		  {{ csrf_field() }}

		  <input type="hidden" class="form-control"  id="po_uuid" name="po_uuid" value="{{$data['po']->uuid}}">

		  <div class="form-group">
		    <label class="control-label" for="po_name"> PO Numbers :</label>
		    <input type="text" class="form-control" id="po_name" name="po_name" value="{{$data['po']->number}}" readonly="">
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="customer_name"> Customer Name :  </label>
		    <select class="form-control" id="po_customer_id" name="po_customer_id" required="">
		    	@foreach($data['customer'] as $key=>$val)
		    	<option value="{{$val['id']}}"
		    	<?php if($data['po']->customer_id == $val['id']) { echo "selected"; } ?>
		    	> 
		    		{{$val->name}} 
		    	</option>
		    	@endforeach
		    </select>
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="category">Category :</label>
	    	<select class="form-control" id="po_category" name="po_category" required="">
              	@foreach($data['category'] as $key=>$val)
              	<option value="{{$val['id']}}"
              	<?php if($data['po']->category_id == $val['id']) { echo "selected"; } ?>
              	> 
              		{{$val['name']}} 
              	</option>
              	@endforeach
        	</select>
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="note"> Note :</label>
		    <textarea class="form-control" rows="4" id="po_note" name="po_note">{{$data['po']['note']}}</textarea>
		  </div>

		  <div class="form-group"> 
		     <div class="btn btn-primary btn-block" id="po_set_submit" onclick="update_po()"> Update PO </div>
		  </div>

		  <div class="clearfix"> </div>
		</form>

	</div>

	<script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
  		});

		function update_po() {
			po_uuid = $('#po_uuid').val();
			po_customer_id = $('#po_customer_id').val();
			po_category = $('#po_category').val();
			po_note = $('#po_note').val();

			var payload = {
				"po_uuid":po_uuid,
				"po_customer_id":po_customer_id,
				"po_category":po_category,
				"po_note":po_note
			};

			$.ajax({
				type : "POST",
				url: " {{ route('po.update_po_by_po_uuid') }}",
				contentType: "application/json",
				data : JSON.stringify(payload),
				success: function(result) {
					response = JSON.parse(result);
					if(response.error != true) {
						alert("update PO success!");
              			window.location = "{{route('po.index')}}";
					} else {
						alert(response.messages);
					}
				}
			});

		}
	</script>

  
@endsection
