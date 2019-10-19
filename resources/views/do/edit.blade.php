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
					<tr>
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
							<span id="item_sub_do_uuid_{{$no}}">{{$val->uuid}}</span>
							<div class="btn btn-warning <?php if($val->deleted_at != null) { echo "hide"; } ?>" 
							onclick="edit_item('{{$no}}')" id="item_edit_btn_{{$no}}"> 
								edit item
							</div>
							<div class="btn btn-success hide" onclick="update_item('{{$no}}')" id="item_update_btn_{{$no}}">
								update item
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



  		function edit_item(current_no_items) {
			$('#item_quantity_'+current_no_items).prop('disabled', false);
			$('#item_name_'+current_no_items).prop('disabled', false);
			$('#item_edit_btn_'+current_no_items).hide();
			// $('#item_delete_btn_'+current_no_items).hide();
			$('#item_update_btn_'+current_no_items).removeClass("hide");
		}

  	</script>

@endsection
