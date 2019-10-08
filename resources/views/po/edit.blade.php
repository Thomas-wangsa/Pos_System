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

		  <div class="clearfix"> </div>
		</form>

		<div id="main_section_body" class="main_section_body">

		    <button class="btn btn-danger" id="btn_add_items" style="margin-bottom: 5px" onclick="add_items()"> 
		    	<span class="glyphicon glyphicon-plus"></span>
		    	add items 
		    </button>

		    <span id="new_po_uuid" class="hide">{{$data['po']['uuid']}}</span> 

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
					<?php $no = 1;?>
					@if(count($data['sub_po']) > 0)
					@foreach($data['sub_po'] as $key=>$val)
					<tr>
						<td> {{$no}} </td>
						<td>
							<input type="number" class="form-control" id="item_quantity_{{$no}}"
							onchange="adjust_quantity(this,'{{$no}}')"  
							value="{{$val->quantity}}" disabled="">
						</td>
						<td>
							<input type="text" class="form-control"
							value="{{$val->name}}" disabled=""> 
							 
						</td>
						<td> 
							<input type="number" class="form-control" id="item_name_{{$no}}"
							onchange="adjust_quantity(this,'{{$no}}')"  
							value="{{$val->price}}" disabled="">
						</td>
						<td> 
							<select class="form-control" id="item_status_{{$no}}" disabled=""> 
								@foreach($data['sub_po_status'] as $key_sub_po_status=>$val_sub_po_status)
								<option value="{{$val_sub_po_status->id}}"
								@if($val_sub_po_status->id == $val->status) selected @endif
								> 
									{{$val_sub_po_status->name}} 
								</option>
								@endforeach
							</select>
						</td>
						<td>
							<textarea class="form-control" rows="3" id="item_note_'+no_items+'" disabled="">{{$val->note}}</textarea>
						</td>
						<td> 
							<span id="item_sub_po_uuid_{{$no}}" class="hide"> </span>
							<button class="btn btn-warning" onclick="edit_item('{{$no}}')" id="item_edit_btn_{{$no}}"> 
								edit item
							</button>
							<button class="btn btn-success hide" onclick="update_item('{{$no}}')" id="item_update_btn_{{$no}}">
								update item
							</button>
						</td>
					</tr>
					<?php $no++; ?>
					@endforeach
					@else
					<tr>
						<td colspan="10"> no items found !</td>
					</tr>
					@endif
				</tbody>
			</table>

		</div>

		<div class="btn btn-primary btn-block" id="po_set_submit" onclick="update_po()"> Update PO </div>

	</div>

	<script type="text/javascript">
		no_items = <?php echo $no; ?>;

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


		function add_items() {
			<?php $faker_name = $data['faker']->name; ?>
			$('#btn_add_items').prop('disabled', true);
			data = "<tr> ";
			data += "<td>"+no_items+"</td>";
			data += '<td width="30px">'+
					'<input type="number" onchange=adjust_quantity(this,'+no_items+') class="form-control" id="item_quantity_'+no_items+'" value="1">'+
					'</td>';
			data += '<td>'+
						'<input type="text" class="form-control" '+
						"value='@if(env('ENV_STATUS', 'development') == 'development'){{$faker_name}} @endif'" +
						' id="item_name_'+no_items+'">'+
					'</td>';
			data += '<td width="60px">'+
					'<input type="number" onchange=adjust_value(this,'+no_items+') class="form-control" id="item_price_'+no_items+'" value="1000">'+
					'</td>';
			data += "<td> ";
			data += '<select class="form-control" id="item_status_'+no_items+'"> ';

			@foreach($data['sub_po_status'] as $key=>$val)
				data += '<option value='+
							"{{$val['id']}} " +
							@if($val['id'] == 2) 
							'selected' +
							@endif
						'>';
				data += '{{$val["name"]}}';
				data += "</option>" ;
			@endforeach

			data += "</select> ";
			data += "</td>";
			data += '<td>  <textarea class="form-control" rows="3" id="item_note_'+no_items+'"></textarea> </td>';
			data += '<td>'+
					'<span id="item_sub_po_uuid_'+no_items+'" class="hide"> </span>' +
					'<button class="btn btn-primary" onclick="save_item('+no_items+')" id="item_save_btn_'+no_items+'"> '+
						'save item '+
					'</button>'+
					'<button class="btn btn-warning hide" onclick="edit_item('+no_items+')" id="item_edit_btn_'+no_items+'"> '+
						' edit item '+
					'</button>'+
					'<button class="btn btn-success hide" onclick="update_item('+no_items+')" id="item_update_btn_'+no_items+'">'+
						' update item '+
					'</button>'+
					'</td>';
			data += "</tr>";
			$('#po_tbody').append(data);
		}

		function save_item(current_no_items) {
			po_uuid = $('#new_po_uuid').html();
			item_quantity = $('#item_quantity_'+current_no_items).val();
			item_name = $('#item_name_'+current_no_items).val();
			item_price = $('#item_price_'+current_no_items).val();
			item_status = $('#item_status_'+current_no_items).val();
			item_note = $('#item_note_'+current_no_items).val();

			if(po_uuid == null || po_uuid == "") {
				alert("error : po_uuid is null");
				return;
			} else if(item_name == null || item_name == "") {
				alert("please input the item name");
				return;
			} else if(item_quantity == null || item_quantity < 1) {
				alert("error : quantity is not correct");
				return;
			} else if(item_price == null || item_price < 1) {
				alert("please input the item price");
				return;
			}

			var payload = {
				"po_uuid":po_uuid,
				"item_quantity":item_quantity,
				"item_name":item_name,
				"item_price":item_price,
				"item_status":item_status,
				"item_note":item_note
			}

			$.ajax({
				type : "POST",
				url: " {{ route('po.submit_sub_po_by_po_uuid') }}",
				contentType: "application/json",
				data : JSON.stringify(payload),
				success: function(result) {
					response = JSON.parse(result);
					if(response.error != true) {
						$('#item_quantity_'+current_no_items).prop('disabled', true);
						$('#item_name_'+current_no_items).prop('disabled', true);
						$('#item_price_'+current_no_items).prop('disabled', true);
						$('#item_status_'+current_no_items).prop('disabled', true);
						$('#item_note_'+current_no_items).prop('disabled', true);
						$('#item_save_btn_'+current_no_items).hide();
						$('#item_edit_btn_'+current_no_items).removeClass("hide");
						$('#submit_detail_po').removeClass("hide");
						no_items = no_items + 1;
						$('#item_sub_po_uuid_'+current_no_items).html(response.data.uuid);
						$('#btn_add_items').prop('disabled', false);
					} else {
						alert(response.messages);
					}
				}
			});
		}

		function edit_item(current_no_items) {
			$('#item_quantity_'+current_no_items).prop('disabled', false);
			$('#item_name_'+current_no_items).prop('disabled', false);
			$('#item_price_'+current_no_items).prop('disabled', false);
			$('#item_status_'+current_no_items).prop('disabled', false);
			$('#item_note_'+current_no_items).prop('disabled', false);
			$('#item_edit_btn_'+current_no_items).hide();
			$('#item_update_btn_'+current_no_items).removeClass("hide");
		}


		function update_item(current_no_items) {
			sub_po_uuid = $('#item_sub_po_uuid_'+current_no_items).html();
			item_quantity = $('#item_quantity_'+current_no_items).val();
			item_name = $('#item_name_'+current_no_items).val();
			item_price = $('#item_price_'+current_no_items).val();
			item_status = $('#item_status_'+current_no_items).val();
			item_note = $('#item_note_'+current_no_items).val();

			if(sub_po_uuid == null || sub_po_uuid == "") {
				alert("error : sub_po_uuid is null");
				return;
			} else if(item_name == null || item_name == "") {
				alert("please input the item name");
				return;
			} else if(item_quantity == null || item_quantity < 1) {
				alert("error : quantity is not correct");
				return;
			} else if(item_price == null || item_price < 1) {
				alert("please input the item price");
				return;
			}

			var payload = {
				"sub_po_uuid":sub_po_uuid,
				"item_quantity":item_quantity,
				"item_name":item_name,
				"item_price":item_price,
				"item_status":item_status,
				"item_note":item_note
			}

			$.ajax({
				type : "POST",
				url: " {{ route('po.update_sub_po_by_sub_po_uuid') }}",
				contentType: "application/json",
				data : JSON.stringify(payload),
				success: function(result) {
					response = JSON.parse(result);
					if(response.error != true) {
						$('#item_quantity_'+current_no_items).prop('disabled', true);
						$('#item_name_'+current_no_items).prop('disabled', true);
						$('#item_price_'+current_no_items).prop('disabled', true);
						$('#item_status_'+current_no_items).prop('disabled', true);
						$('#item_note_'+current_no_items).prop('disabled', true);
						$('#item_edit_btn_'+current_no_items).show();
						$('#item_update_btn_'+current_no_items).addClass("hide");
					} else {
						alert(response.messages);
					}
				}
			});
		}

		function adjust_value(price,current_no_items) {
			this_value = price.value;

			if(this_value < 1) {
				$('#item_price_'+current_no_items).val(0);
				alert("price is not correct!");
			}
		}
	</script>

  
@endsection
