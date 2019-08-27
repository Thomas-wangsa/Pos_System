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
		
		<div class="main_section_information" style="margin-bottom: 10px">
			<strong> Category : </strong> {{$data['customer']->category_id}} 
			<br/>
			<strong> Customer Name : </strong> {{$data['customer']->name}} 
			<br/>
			<strong> Sales ID : </strong> {{$data['customer']->sales_id}} 
			<br/>
		</div>


		<form class="form-inline" action="/action_page.php">
		  <div class="form-group">
		    <label for="po_name"> PO Name : </label>
		    <input type="text" class="form-control" id="po_name" name="po_name">
		  </div>
		  &nbsp;&nbsp;&nbsp;
		  <div class="form-group">
		    <label for="po_date"> Date : </label>
		    <input type="text" class="form-control" id="po_date" name="po_date">
		  </div>
		  &nbsp;&nbsp;&nbsp;
		  <div class="form-group">
		    <label for="po_note"> Note : </label>
		    <input type="text" class="form-control" id="po_note" name="po_note">
		  </div>
		</form>


		<div style="margin: 10px auto">
	      <button type="button" class="btn btn-md btn-primary" onclick="add_po_rows()">
	        <span class="glyphicon glyphicon-plus"></span>
	        Add PO Detail
	      </button>
		 </div>

		<div class="main_section_body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr> 
						<th> No </th>
						<th width="100px"> Quantity </th>
						<th> Name </th>
						<th width="150px"> Price </th>
						<th> Status </th>
						<th> Additional Note </th>
					</tr>
				</thead>
				<tbody id="po_tbody">
				</tbody>
			</table>
		</div>

		<button type="button" class="btn btn-success btn-block" id="add_po" onclick="add_po_rows()"> add new rows </button>
		<button type="button" class="btn btn-primary btn-block" id="save_po_btn" onclick="save_po_btn()"> Save PO </button>

	</div>


<script type="text/javascript">

$('#save_po_btn').hide();
no_rows = 0;
function add_po_rows() {
	po_tbody = $('#po_tbody');

	append_rows = "<tr> " +
		"<td> " + (no_rows+1) +" </td>" +  
		'<td> <input type="number" class="form-control" id="quantity'+no_rows+'" value="1"> </td>' +
		'<td> <input type="text" class="form-control" id="name'+no_rows+'">  </td>' +
		'<td> <input type="number" class="form-control" id="price'+no_rows+'"> </td>' + 
		'<td>' + 
		'<select class="form-control" id="status'+no_rows+'">'+
			'<option value="1"> urgent </option>' +
			'<option value="2" selected> normal </option>' +
			'<option value="3"> low </option>' +
		'</select>' + 
		'</td>' + 
		'<td> <input type="text" class="form-control" id="note'+no_rows+'"> </td>' + 
				  "<tr> ";

	po_tbody.append(append_rows);
	no_rows++;
	$('#save_po_btn').show();
}



function save_po_btn() {
	po_name = $('#po_name').val();
	po_date = $('#po_date').val();
	po_note = $('#po_note').val();


	po = {
		"po_name":po_name,
		"po_date":po_date,
		"po_note":po_note
	};

	var subData = [];
	for (i = 0; i < no_rows; i++) {

		quantityValue = $('#quantity'+i).val();
		nameValue = $('#name'+i).val();
		priceValue = $('#price'+i).val();
		noteValue = $('#note'+i).val();
		var data = {quantity:quantityValue, name:nameValue, price:priceValue,note:noteValue};
		subData.push(data);

	}

	data = {
		"customer_uuid": "{{ app('request')->input('customer_uuid') }}", 
		"po":po,
		"subData":subData
	}


	$.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $.ajax({
      type : "POST",
      url: " {{ route('po.store') }}",
      contentType: "application/json",
      data : JSON.stringify(data),
      success: function(result) {
        response = JSON.parse(result);
		//console.log(response);
		if(response.error == true) {
			alert(response.message); 
		} else {
			alert("set location success!");
			var url = "{{route('po.index')}}";
			window.location = url;
		}
      }
    });

}
</script>
  
@endsection
