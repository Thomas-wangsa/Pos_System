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

		  <input type="hidden" class="form-control"  id="customer_uuid" name="customer_uuid" value="{{$data['customer']->uuid}}">

		  <div class="form-group">
		    <label class="control-label" for="customer_name"> Customer Name :  </label>
		    <input type="text" class="form-control" value="{{$data['customer']->name}}" readonly="">
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="sales_name"> Sales Name :</label>
		    <input type="text" class="form-control" value="{{$data['customer']->sales_name}}" readonly="">
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="po_name"> PO Numbers :</label>
		    <input type="text" class="form-control" id="po_name" name="po_name" value="{{$data['patern_po_name']}}" readonly="">
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="category">Category :</label>
	    	<select class="form-control" id="po_category" name="po_category" required="">
		    	<option value=""> Select Category </option>
              	@foreach($data['category'] as $key=>$val)
              	<option value="{{$val->id}}"> {{$val->name}} </option>
              	@endforeach
        	</select>
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="note"> Note :</label>
		    <textarea class="form-control" rows="5" id="po_note" name="po_note"></textarea>
		  </div>

		  <div class="form-group"> 
		    <div class="col-md-6">
		      <div class="btn btn-primary btn-block" id="po_set_submit" onclick="submit_po()"> Submit and set item </div>
		    </div>
		  </div>

		  <div class="form-group"> 
		    <div class="col-md-6">
		      <button type="submit" id="po_set_draft" class="btn btn-warning btn-block"> Set as Draft </button>
		    </div>
		  </div>
		  <div class="clearfix"> </div>
		</form>

		<div id="main_section_body" class="main_section_body hide">

		    <button class="btn btn-danger" id="btn_add_items" style="margin-bottom: 5px" onclick="add_items()"> 
		    	<span class="glyphicon glyphicon-plus"></span>
		    	add items 
		    </button>

		    <span id="new_po_uuid"> po_uuid </span> 

			<table class="table table-bordered table-striped">
				<thead>
					<tr> 
						<th> No </th>
						<th width="100px"> Quantity </th>
						<th> Name </th>
						<th width="150px"> Price </th>
						<th> Status </th>
						<th> Additional Note </th>
						<th> Action </th>
					</tr>
				</thead>
				<tbody id="po_tbody">
				</tbody>
			</table>
		</div>

	</div>

	<script type="text/javascript">
		no_items = 1;
	
		$.ajaxSetup({
		    headers: {
		      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
  		});
		
		function submit_po() {
			customer_uuid = $('#customer_uuid').val();
			po_name = $('#po_name').val();
			po_category = $('#po_category').val();
			po_note = $('#po_note').val();

			if(customer_uuid == null || customer_uuid == "") {
				alert("error : customer_uuid is null");
				return;
			} else if(po_name == null || po_name == "") {
				alert("error : po_name is null");
				return;
			} else if(po_category == null || po_category == "") {
				alert("select the category first!");
				return;
			}


			var payload = {
				"customer_uuid":customer_uuid,
				"po_name":po_name,
				"po_category":po_category,
				"po_note":po_note
			};

			$.ajax({
				type : "POST",
				url: " {{ route('po.submit_po_by_customer_uuid') }}",
				contentType: "application/json",
				data : JSON.stringify(payload),
				success: function(result) {
					response = JSON.parse(result);
					if(response.error != true) {
						$('#po_category').prop('disabled', true);
						$('#po_note').prop('disabled', true);
						$('#po_set_submit').hide();
						$('#po_set_draft').hide();
						$('#main_section_body').removeClass("hide");

						$('#new_po_uuid').html(response.data.uuid);
					} else {
						alert(response.messages);
					}
				}
			});
		}

		function add_items() {
			$('#btn_add_items').prop('disabled', true);
			data = "<tr> ";
			data += "<td>"+no_items+"</td>";
			data += '<td> <input type="number" class="form-control" id="item_quantity_'+no_items+'" value="1"> </td>';
			data += '<td> <input type="text" class="form-control" id="item_name_'+no_items+'"> </td>';
			data += '<td> <input type="number" class="form-control" id="item_price_'+no_items+'"> </td>';
			data += "<td> ";
			data += '<select class="form-control" id="item_status'+no_items+'"> ';

			@foreach($data['sub_po_status'] as $key=>$val)
				data += "<option> aaa </option>";
			@endforeach

			data += "</select> ";
			data += "</td>";
			data += "<td> 1 </td>";
			data += "<td> 1 </td>";
			data += "</tr>";
			$('#po_tbody').append(data);
		}
	</script>

  
@endsection
