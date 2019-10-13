@extends('layouts.main')

@section('content')
<style type="text/css">
</style>
	
	<div style="margin: 10px auto">
	    <a href="{{route('do.index')}}">
	      <button type="button" class="btn btn-md btn-warning">
	        <span class="glyphicon glyphicon-chevron-left "></span>
	        Back
	      </button>
	    </a>
  	</div>


	<div class="main_section">	
		


		<div class="main_section_information" style="margin-bottom: 10px">
			<strong> Customer Name : </strong> -
			<br/>
			<strong> PO Number : </strong> {{$data['po']->number}} 
			<br/>
			<strong> Sales ID : </strong> {{$data['po']->sales_id}} 
			<br/>
		</div>

		<form class="form-inline" action="/action_page.php">

			<div class="form-group">
		      	<label for="driver_id"> Driver : </label>
		        <select class="form-control" id="driver_id" name="driver_id">
		          <option value=""> Select Driver </option>
		          @if (count($data['driver']) > 0 )
		          	@foreach($data['driver'] as $key=>$val)
		          	<option value="{{$val->id}}"> {{$val->name}} </option>
		          	@endforeach
		          @endif 
		        </select>
	      	</div>
			<div class="form-group">
			    <label for="do_name"> Delivery_order Number : </label>
			    <input type="text" class="form-control" id="do_name" name="do_name">
			</div>
			&nbsp;&nbsp;&nbsp;
			<div class="form-group">
			    <label for="do_date"> Date : </label>
			    <input type="text" class="form-control" id="do_date" name="do_date">
			</div>
			&nbsp;&nbsp;&nbsp;
			<div class="form-group">
			    <label for="do_note"> Note : </label>
			    <input type="text" class="form-control" id="do_note" name="do_note">
			</div>
		</form>


		<div style="margin: 10px auto">
	      <button type="button" class="btn btn-md btn-primary" onclick="add_po_rows()">
	        <span class="glyphicon glyphicon-plus"></span>
	        Add DO Detail
	      </button>
		 </div>

		<div class="main_section_body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr> 
						<th> No </th>
						<th width="100px"> Quantity </th>
						<th> Name </th>
						<th> Additional Note </th>
					</tr>
				</thead>
				<tbody id="po_tbody">
				</tbody>
			</table>
		</div>

		<button type="button" class="btn btn-success btn-block" id="add_po" onclick="add_po_rows()"> add new rows </button>
		<button type="button" class="btn btn-primary btn-block" id="save_po_btn" onclick="save_po_btn()"> Save Delivery Order </button>

	</div>


<script type="text/javascript">

$('#save_po_btn').hide();
no_rows = 0;
function add_po_rows() {
	po_tbody = $('#po_tbody');

	append_rows = "<tr> " +
		"<td> " + (no_rows+1) +" </td>" +  
		'<td> <input type="number" class="form-control" id="quantity'+no_rows+'" value="1"> </td>' +

		'<td>' + 
		'<select class="form-control" id="name'+no_rows+'">'+
			'<option value=""> select name </option>' +
		'</select>' + 
		'</td>' + 

		'<td> <input type="text" class="form-control" id="note'+no_rows+'"> </td>' + 
				  "<tr> ";

	po_tbody.append(append_rows);
	generate_sub_po_name(no_rows);
	no_rows++;
	
	$('#save_po_btn').show();
}



function generate_sub_po_name(no_rows) {
	data = <?php echo $data['sub_po'];?> ;

	po_tbody = $('#name'+no_rows);
	$.each(data, function(key, value) { 
        append_rows = '<option value="'+value.name+'"> '+value.name+' </option>';
        po_tbody.append(append_rows);
    });
}

function save_po_btn() {


	delivery_order = {
		"driver_id":$('#driver_id').val(),
		"do_name":$('#do_name').val(),
		"do_date":$('#do_date').val(),
		"do_note":$('#do_note').val()
	};

	var subData = [];
	for (i = 0; i < no_rows; i++) {

		quantityValue = $('#quantity'+i).val();
		nameValue = $('#name'+i).val();
		statusValue = $('#status'+i).val();
		noteValue = $('#note'+i).val();
		var data = {quantity:quantityValue, name:nameValue,status:statusValue,note:noteValue};
		subData.push(data);

	}

	data = {
		"po_uuid": "{{ app('request')->input('po_uuid') }}", 
		"delivery_order":delivery_order,
		"subData":subData
	}


	$.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $.ajax({
      type : "POST",
      url: " {{ route('do.store') }}",
      contentType: "application/json",
      data : JSON.stringify(data),
      success: function(result) {
        response = JSON.parse(result);
		//console.log(response);
		if(response.error == true) {
			alert(response.message); 
		} else {
			var url = "{{route('do.index')}}";
			window.location = url;
		}
      }
    });

}
</script>
  
@endsection
