@extends('layouts.main')

@section('content')
<style type="text/css">
	.main_section {margin-top: 20px}

	.unselectable{
   background-color: #ddd;
   cursor: not-allowed;
  }
</style>
	<div style="margin: 10px auto">
	    <a href="{{route('do.index')}}">
	      <button type="button" class="btn btn-md btn-warning">
	        <span class="glyphicon glyphicon-chevron-left "></span>
	        Back to Delivery Order Page
	      </button>
	    </a>
  	</div>

  	<div class="main_section">

  		<form action="{{route('do.update',$data['do']->uuid)}}" method="POST">
  			{{ csrf_field() }}
    		<input type="hidden" name="_method" value="PUT">
	  		<div class="form-group">
			    <label class="control-label" for="do_driver"> Driver :</label>
		    	<select class="form-control" id="do_driver" name="do_driver" required="">
			    	<option value=""> Select Driver </option>
	              	@foreach($data['driver'] as $key=>$val)
	              	<option value="{{$val->id}}"
	              	<?php if($data['do']->driver_id == $val->id) { echo "selected"; } ?>
	              	> 
	              		{{$val->name}} - {{$val->detail}}
	              	</option>
	              	@endforeach
	        	</select>
			 </div>

			 <div class="form-group">
			    <label class="control-label" for="do_po"> Number  :</label>
			    <input class="form-control" type="text" name="do_customer" id="do_customer" value="{{$data['do']->number}}" disabled="">
			</div>

			<div class="form-group">
			    <label class="control-label" for="do_po"> Customer  :</label>
			    <input class="form-control" type="text" name="do_customer" id="do_customer" value="{{$data['do']->customer_name}}" disabled="">
			</div>

			<div class="form-group">
			    <label class="control-label" for="do_po"> PO  :</label>
			    <input class="form-control" type="text" name="do_po" id="do_po" value="{{$data['do']->po_number}}" disabled="">
			</div>

			<div class="form-group">
			    <label class="control-label" for="do_po"> Sales :</label>
			    <input class="form-control" type="text" name="do_sales" id="do_sales" value="{{$data['do']->sales_name}}" disabled="">
			</div>


			<div class="btn btn-warning" id="btn_add_items" style="margin-bottom: 5px" onclick="add_items()"> 
		    	<span class="glyphicon glyphicon-plus"></span>
		    	add items 
		    </div>


		    <span id="new_do_uuid" class="hide">{{$data['do']['uuid']}}</span> 

			<table class="table table-bordered">
				<thead>
					<tr> 
						<th width="30px"> No </th>
						<th width="100px"> Quantity </th>
						<th> Name </th>
						<th> Action </th>
					</tr>
				</thead>
				<tbody id="do_tbody">
				<?php $no = 1;?>
				@if(count($data['sub_do']) > 0)
					@foreach($data['sub_do'] as $key=>$val)
					<tr id="tr_no_{{$no}}" class="<?php if($val->deleted_at != null) { echo "unselectable"; } ?>">
						<td> {{$no}} </td>
						<td>
							<input type="number" class="form-control" id="item_quantity_{{$no}}"
							onchange="adjust_quantity(this,'{{$no}}')"  
							value="{{$val->quantity}}" disabled=""> 
						</td>
						<td> 
							<input type="text" class="form-control" id="item_name_{{$no}}"
							value="{{$val->name}}" disabled="">
						</td>
						<td>
							<span id="item_sub_do_uuid_{{$no}}" class="hide">{{$val->uuid}}</span>
							<div class="btn btn-warning <?php if($val->deleted_at != null) { echo "hide"; } ?>" 
							onclick="edit_item('{{$no}}')" id="item_edit_btn_{{$no}}"> 
								edit item
							</div>
							<div class="btn btn-success hide" onclick="update_item('{{$no}}')" id="item_update_btn_{{$no}}">
								update item
							</div>
							<div class="btn btn-danger <?php if($val->deleted_at != null) { echo "hide"; } ?>" 
							onclick="delete_item('{{$no}}')" id="item_delete_btn_{{$no}}">
								delete item
							</div>
							<div class="btn btn-primary <?php if($val->deleted_at == null) { echo "hide"; } ?>" 
							onclick="restore_item('{{$no}}')" id="item_restore_btn_{{$no}}">
								restore item
							</div>
						</td>
					</tr>
					<?php $no++; ?>
					@endforeach
				@else
					<tr> 
						<td colspan="5"> no data found </td>
					</tr>
				@endif
				</tbody>
			</table>

			<div class="text-center" style="margin-top: 50px">
		      <button type="submit" class="btn btn-primary btn-block">
		        <span class="glyphicon glyphicon-plus"></span> update delivery order 
		      </button>
		    </div>

		</form>

  	</div>

  	<script type="text/javascript">
  		no_items = <?php echo $no; ?>;

  		$.ajaxSetup({
		    headers: {
		      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
  		});


  		function add_items() {
  			data = '<tr id="tr_no_'+no_items+'"> ';
			data += "<td>"+no_items+"</td>";
			data += '<td width="30px">'+
					'<input type="number" onchange=adjust_quantity(this,'+no_items+') class="form-control" id="item_quantity_'+no_items+'" value="1">'+
					'</td>';
			data += "<td> ";
			data += '<select class="form-control" id="item_name_'+no_items+'"> ';

			@foreach($data['sub_po'] as $key=>$val)
				data += '<option value="{{$val['name']}} " >';
				data += '{{$val["name"]}}';
				data += "</option>" ;
			@endforeach

			data += "</select> ";
			data += "</td>";
			data += '<td>'+
					'<span id="item_sub_do_uuid_'+no_items+'" class="hide"> </span>' +
					'<div class="btn btn-primary" onclick="save_item('+no_items+')" id="item_save_btn_'+no_items+'"> '+
						'save item '+
					'</div>'+
					'<div class="btn btn-warning hide" onclick="edit_item('+no_items+')" id="item_edit_btn_'+no_items+'"> '+
						' edit item '+
					'</div>'+
					'<div class="btn btn-success hide" onclick="update_item('+no_items+')" id="item_update_btn_'+no_items+'">'+
						' update item '+
					'</div>'+
					'&nbsp;' +
					'<div class="btn btn-danger hide" onclick="delete_item('+no_items+')" id="item_delete_btn_'+no_items+'">'+
						' delete item '+
					'</div>'+
					'&nbsp;' +
					'<div class="btn btn-primary hide" onclick="restore_item('+no_items+')" id="item_restore_btn_'+no_items+'">'+
						' restore item '+
					'</div>'+
					'</td>';
			data += "</tr>";
			$('#do_tbody').append(data);
  		}



  		function save_item(current_no_items) {
			do_uuid = $('#new_do_uuid').html();
			item_quantity = $('#item_quantity_'+current_no_items).val();
			item_name = $('#item_name_'+current_no_items).val();
			
			if(do_uuid == null || do_uuid == "") {
				alert("error : do_uuid is null");
				return;
			} else if(item_name == null || item_name == "") {
				alert("please input the item name");
				return;
			} else if(item_quantity == null || item_quantity < 1) {
				alert("error : quantity is not correct");
				return;
			}

			var payload = {
				"do_uuid":do_uuid,
				"item_quantity":item_quantity,
				"item_name":item_name
			}

			$.ajax({
				type : "POST",
				url: " {{ route('do.added_sub_do_by_uuid') }}",
				contentType: "application/json",
				data : JSON.stringify(payload),
				success: function(result) {
					response = JSON.parse(result);
					if(response.error != true) {
						$('#item_quantity_'+current_no_items).prop('disabled', true);
						$('#item_name_'+current_no_items).prop('disabled', true);
						$('#item_save_btn_'+current_no_items).hide();
						$('#item_edit_btn_'+current_no_items).removeClass("hide");
						$('#item_delete_btn_'+current_no_items).removeClass("hide");
						$('#submit_detail_po').removeClass("hide");
						no_items = no_items + 1;
						$('#item_sub_do_uuid_'+current_no_items).html(response.data.uuid);
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
			$('#item_edit_btn_'+current_no_items).hide();
			$('#item_delete_btn_'+current_no_items).hide();
			$('#item_update_btn_'+current_no_items).removeClass("hide");
		}



		function update_item(current_no_items) {
			sub_do_uuid = $('#item_sub_do_uuid_'+current_no_items).html();
			item_quantity = $('#item_quantity_'+current_no_items).val();
			item_name = $('#item_name_'+current_no_items).val();

			if(sub_do_uuid == null || sub_do_uuid == "") {
				alert("error : sub_do_uuid is null");
				return;
			} else if(item_name == null || item_name == "") {
				alert("please input the item name");
				return;
			} else if(item_quantity == null || item_quantity < 1) {
				alert("error : quantity is not correct");
				return;
			} 

			var payload = {
				"sub_do_uuid":sub_do_uuid,
				"item_quantity":item_quantity,
				"item_name":item_name,
			}

			$.ajax({
				type : "POST",
				url: " {{ route('do.update_sub_do_by_uuid') }}",
				contentType: "application/json",
				data : JSON.stringify(payload),
				success: function(result) {
					response = JSON.parse(result);
					if(response.error != true) {
						$('#item_quantity_'+current_no_items).prop('disabled', true);
						$('#item_name_'+current_no_items).prop('disabled', true);
						$('#item_edit_btn_'+current_no_items).show();
						$('#item_delete_btn_'+current_no_items).show();
						$('#item_update_btn_'+current_no_items).addClass("hide");
					} else {
						alert(response.messages);
					}
				}
			});
		}


		function delete_item(current_no_items) {
			if (confirm('Apakah anda yakin ingin menghapus item ini ?')) {
				sub_do_uuid = $('#item_sub_do_uuid_'+current_no_items).html();
				if(sub_do_uuid == null || sub_do_uuid == "") {
					alert("error : sub_do_uuid is null");
					return;
				}

				var payload = {"sub_do_uuid":sub_do_uuid,"_method": 'DELETE'};

				$.ajax({
		          type : "POST",
		          url: " {!! url('do' ) !!}" + "/" + sub_do_uuid,
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
	       		sub_do_uuid = $('#item_sub_do_uuid_'+current_no_items).html();
				if(sub_do_uuid == null || sub_do_uuid == "") {
					alert("error : sub_do_uuid is null");
					return;
				}

				var payload = {"sub_do_uuid":sub_do_uuid};

				$.ajax({
		          type : "POST",
		          url: " {{ route('do.restore_sub_do_by_uuid') }}",
		          contentType: "application/json",
		          data : JSON.stringify(payload),
		          success: function(result) {
		            response = JSON.parse(result);
		            if(response.error != true) {
		            	$('#item_edit_btn_'+current_no_items).show();
		             	$('#item_edit_btn_'+current_no_items).removeClass("hide");
						$('#item_delete_btn_'+current_no_items).show();
						$('#item_delete_btn_'+current_no_items).removeClass("hide");
						$('#item_restore_btn_'+current_no_items).addClass("hide");
						$('#tr_no_'+current_no_items).removeClass('unselectable');
		            } else {
		              alert(response.messages);
		            }
		          }
		        });
	 
	          	
	        } 
	    };

  	</script>

@endsection
