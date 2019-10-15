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
  		<div class="form-group">
		    <label class="control-label" for="do_driver"> Driver :</label>
	    	<select class="form-control" id="do_driver" name="do_driver" required="">
		    	<option value=""> Select Driver </option>
              	@foreach($data['driver'] as $key=>$val)
              	<option value="{{$val->id}}"> {{$val->name}} - {{$val->detail}}</option>
              	@endforeach
        	</select>
		 </div>

		<div class="form-group">
		    <label class="control-label" for="do_customer"> Customer :</label>
	    	<select class="form-control" id="do_customer" name="do_customer" required="">
		    	<option value=""> Select Customer </option>
              	@foreach($data['customer'] as $key=>$val)
              	<option value="{{$val->uuid}}"> {{$val->name}} </option>
              	@endforeach
        	</select>
		</div>

		<div class="form-group">
		    <label class="control-label" for="do_po"> PO :</label>
	    	<select class="form-control" id="do_po" name="do_po" required="">
		    	<option value=""> Select PO </option>
        	</select>
		</div>

		<div class="form-group">
		    <label class="control-label" for="do_po"> Sales :</label>
		    <input class="form-control" type="text" name="do_sales" id="do_sales" disabled="">
		</div>

		<table class="table table-bordered">
			<thead>
				<tr> 
					<th width="5px"> </th>
					<th width="30px"> No </th>
					<th width="100px"> Quantity </th>
					<th> Name </th>
				</tr>
			</thead>
			<tbody id="do_tbody">
			</tbody>
		</table>

		<button class="btn btn-primary btn-block hide" id="create_delivery_order_btn" onclick="submit_delivery_order()" disabled> 
			create delivery order 
		</button>
  	</div>


  	<script type="text/javascript">
  		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
  		});
  		$('#do_customer').change(function(){
		    customer_uuid = $('#do_customer').val();
		    $('#do_tbody').empty();
		    $('#create_delivery_order_btn').addClass("hide");
		    $('#do_sales').val("-");
		    $('#do_po').empty().append(
		      $("<option></option>")
		      .attr("value","")
		      .text("Select PO")
		    );
		    var data = {"customer_uuid":customer_uuid};

		    $.ajax({
		      type : "POST",
		      url: " {{ route('po.get_po_by_customer_uuid') }}",
		      contentType: "application/json",
		      data : JSON.stringify(data),
		      success: function(result) {
		        response = JSON.parse(result);
		        if(response.error == true) {
		          alert(response.messages);
		        } else { 
		          
		          $.each(response.data, function(key, value) { 
		            $('#do_po')
		              .append($("<option></option>")
		              .attr("value",value.uuid)
		              .text(value.number)
		            );
		          });
		        } 
		      }
		    });
		});


		$('#do_po').change(function(){
			$('#do_tbody').empty();
			$('#create_delivery_order_btn').addClass("hide");
			$('#do_sales').val("-");
			po_uuid = $('#do_po').val();
			$('#do_sales').val("-");
			var data = {"po_uuid":po_uuid}

			$.ajax({
				type : "POST",
		      	url: " {{ route('po.get_sales_subpo_by_po_uuid') }}",
		      	contentType: "application/json",
		      	data : JSON.stringify(data),
		      	success: function(result) {
		      		response = JSON.parse(result);
		        	if(response.error == true) {
		          		alert(response.messages);
		          	} else {
		          		$('#do_sales').val(response.data.sales.name);
		          		if(response.data.sub_po.length > 0) {
		          			no_items = 1;
		          			$.each(response.data.sub_po, function (key,val) {
		          				var append_rows = '<tr id="tr_no_'+no_items+'" class="unselectable"> ' +
		          					"<td width='20px'> "+
		          					'<div class="checkbox">'+
		          					'<label>'+
		          					'<input type="checkbox" onclick="cek_checkbox('+no_items+')" id="checkbox_'+no_items+'">'+
		          					'</label> '+
		          					'</div>' +
		          					"</td> " + 

									"<td> " +
									'<input type="text"  class="form-control hide" id=item_uuid_'+no_items+'" value="'+val.uuid+'">'+
									'<span id="item_active_'+no_items+'" class="hide">0</span>' +
									(key+1) +
									"</td> " +
									"<td> " +
									'<input type="number"  onchange=adjust_quantity(this,'+no_items+') class="form-control" id="item_quantity_'+no_items+'" value="'+val.quantity+'" disabled>'+
									"</td> " +
									"<td> " +
									val.name +
									"</td> " +
								  			"<tr>";
								no_items ++;
								$('#do_tbody').append(append_rows);
								$('#create_delivery_order_btn').removeClass("hide");
		          			});

		          		} else {
		          			append_rows = "<tr> <td colspan='7'> no item found! </td> </tr>";
		          			$('#do_tbody').append(append_rows);
		          		}
		          	}
		      	}
			});
		});


		function submit_delivery_order() {
			if (confirm('Are you sure to create this delivery_order ?')) { 
				driver_id = $('#do_driver').val();
				po_uuid = $('#do_po').val();

				if(driver_id == null || driver_id == "") {
					alert("please select the driver!");
					return;
				} else if(po_uuid == null || po_uuid == "") {
					alert("please select the po");
					return;
				}

				full_data = [];
				for(i=1;i<no_items;i++) {
					item = {
						"sub_po_uuid":$('#item_uuid_'+i).val(),
						"quantity":$('#item_quantity_'+i).val(),
						"active":$('#item_active_'+i).html()
					}
					full_data.push(item);
				}

				

			}
		}

		function adjust_quantity(qty,current_no_items) {
			this_value = qty.value;

			if(this_value < 1) {
				$('#item_quantity_'+current_no_items).val(1);
				alert("quantity is not correct!");
			}
		}

		function checking_eligible() {
			$('#create_delivery_order_btn').attr('disabled',true);
			for(i=1;i<no_items;i++) {
				value = $('#item_active_'+i).html();
				if(value == 1) {
					$('#create_delivery_order_btn').attr('disabled',false);
				}
			}
		}

		function cek_checkbox(current_no_items) {
			if($('#checkbox_'+current_no_items).prop('checked')) {
			    $('#tr_no_'+current_no_items).removeClass('unselectable');
				$('#pick_item_btn_'+current_no_items).addClass('hide');
				$('#remove_item_btn_'+current_no_items).removeClass('hide');
				$('#item_quantity_'+current_no_items).attr('disabled',false);
				$('#item_active_'+current_no_items).html(1);
				checking_eligible(); 
			} else {
			    $('#tr_no_'+current_no_items).addClass('unselectable');
				$('#pick_item_btn_'+current_no_items).removeClass('hide');
				$('#remove_item_btn_'+current_no_items).addClass('hide');
				$('#item_quantity_'+current_no_items).attr('disabled',true);
				$('#item_active_'+current_no_items).html(0);
				checking_eligible(); 
			}
		}

		function pick_item(current_no_items) {
			$('#tr_no_'+current_no_items).removeClass('unselectable');
			$('#pick_item_btn_'+current_no_items).addClass('hide');
			$('#remove_item_btn_'+current_no_items).removeClass('hide');
			$('#item_active_'+current_no_items).html(1);
		}

		function remove_item(current_no_items) {
			$('#tr_no_'+current_no_items).addClass('unselectable');
			$('#pick_item_btn_'+current_no_items).removeClass('hide');
			$('#remove_item_btn_'+current_no_items).addClass('hide');
			$('#item_active_'+current_no_items).html(0);
		}
  	</script>
@endsection
