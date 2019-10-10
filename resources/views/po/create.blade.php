@extends('layouts.main')

@section('content')
<style type="text/css">
  .unselectable{
   background-color: #ddd;
   cursor: not-allowed;
  }
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
		    <label class="control-label" for="po_name"> PO Numbers :</label>
		    <input type="text" class="form-control" id="po_name" name="po_name" value="{{$data['patern_po_name']}}" readonly="">
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="customer_name"> Customer Name :  </label>
		    <input type="text" class="form-control" value="{{$data['customer']->name}}" readonly="">
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="sales_name"> Sales Name :</label>
		    <input type="text" class="form-control" value="{{$data['customer']->sales_name}}" readonly="">
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
		    <textarea class="form-control" rows="4" id="po_note" name="po_note"></textarea>
		  </div>

		  <div class="form-group"> 
		     <div class="btn btn-primary btn-block" id="po_set_submit" onclick="submit_po()"> Submit and set item </div>
		  </div>

		  <div class="clearfix"> </div>
		</form>

		<div id="main_section_body" class="main_section_body hide">

		    <button class="btn btn-danger" id="btn_add_items" style="margin-bottom: 5px" onclick="add_items()"> 
		    	<span class="glyphicon glyphicon-plus"></span>
		    	add items 
		    </button>

		    <span id="new_po_uuid" class="hide"> </span> 

			<table class="table table-bordered">
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

			<div style="margin: 10px auto">
			    <a href="{{route('po.index')}}">
			      <button class="btn btn-block btn-primary hide" id="submit_detail_po">
			        <span class="glyphicon glyphicon-chevron-left "></span>
			        Back to PO page
			      </button>
			    </a>
		  	</div>

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
			<?php $faker_name = $data['faker']->name; ?>
			$('#btn_add_items').prop('disabled', true);
			data = '<tr id="tr_no_'+no_items+'"> ';
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
					'&nbsp;<button class="btn btn-danger hide" onclick="delete_item('+no_items+')" id="item_delete_btn_'+no_items+'">'+
						' delete item '+
					'</button>'+
					'</button>'+
					'&nbsp;<button class="btn btn-primary hide" onclick="restore_item('+no_items+')" id="item_restore_btn_'+no_items+'">'+
						' restore item '+
					'</button>'+
					'</td>';
			data += "</tr>";
			$('#po_tbody').append(data);
		}

		function adjust_quantity(qty,current_no_items) {
			this_value = qty.value;

			if(this_value < 1) {
				$('#item_quantity_'+current_no_items).val(1);
				alert("quantity is not correct!");
			}
		}

		function adjust_value(price,current_no_items) {
			this_value = price.value;

			if(this_value < 1) {
				$('#item_price_'+current_no_items).val(0);
				alert("price is not correct!");
			}
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
						$('#item_delete_btn_'+current_no_items).removeClass("hide");
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


		function delete_item(current_no_items) {
			if (confirm('Apakah anda yakin ingin menghapus item ini ?')) {
				sub_po_uuid = $('#item_sub_po_uuid_'+current_no_items).html();
				if(sub_po_uuid == null || sub_po_uuid == "") {
					alert("error : sub_po_uuid is null");
					return;
				}

				var payload = {"sub_po_uuid":sub_po_uuid,"_method": 'DELETE'};

				$.ajax({
		          type : "POST",
		          url: " {!! url('po' ) !!}" + "/" + sub_po_uuid,
		          contentType: "application/json",
		          data : JSON.stringify(payload),
		          success: function(result) {
		            response = JSON.parse(result);
		            if(response.error != true) {
		            	$('#item_edit_btn_'+current_no_items).hide();
						$('#item_delete_btn_'+current_no_items).hide();
						$('#item_restore_btn_'+current_no_items).removeClass("hide");
						$('#tr_no_'+current_no_items).addClass('unselectable');

		            } else {
		              alert(response.messages);
		            }
		          }
		        });
		    }
		}


		function restore_item(current_no_items) {
	       	if (confirm('Apakah anda yakin ingin restore item ini ?')) {
	       		sub_po_uuid = $('#item_sub_po_uuid_'+current_no_items).html();
				if(sub_po_uuid == null || sub_po_uuid == "") {
					alert("error : sub_po_uuid is null");
					return;
				}

				var payload = {"sub_po_uuid":sub_po_uuid};

				$.ajax({
		          type : "POST",
		          url: " {{ route('po.restore_sub_po_by_sub_po_uuid') }}",
		          contentType: "application/json",
		          data : JSON.stringify(payload),
		          success: function(result) {
		            response = JSON.parse(result);
		            if(response.error != true) {
		            	$('#item_edit_btn_'+current_no_items).show();
						$('#item_delete_btn_'+current_no_items).show();
						$('#item_restore_btn_'+current_no_items).addClass("hide");
						$('#tr_no_'+current_no_items).removeClass('unselectable');
		            } else {
		              alert(response.messages);
		            }
		          }
		        });
	 
	          	
	        } 
	    };


		function edit_item(current_no_items) {
			$('#item_quantity_'+current_no_items).prop('disabled', false);
			$('#item_name_'+current_no_items).prop('disabled', false);
			$('#item_price_'+current_no_items).prop('disabled', false);
			$('#item_status_'+current_no_items).prop('disabled', false);
			$('#item_note_'+current_no_items).prop('disabled', false);
			$('#item_edit_btn_'+current_no_items).hide();
			$('#item_delete_btn_'+current_no_items).hide();
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
						$('#item_delete_btn_'+current_no_items).show();
						$('#item_update_btn_'+current_no_items).addClass("hide");
					} else {
						alert(response.messages);
					}
				}
			});
		}


		function formatNumber(num) {
  			return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
		}
	</script>

  
@endsection
