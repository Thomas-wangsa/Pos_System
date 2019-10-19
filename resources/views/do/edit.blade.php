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
				</tr>
			</thead>
			<tbody id="do_tbody">
			@if(count($data['sub_do']) > 0)
				@foreach($data['sub_do'] as $key=>$val)
				<tr>
					<td> </td>
					<td> </td>
					<td> </td>
				</tr>
				@endforeach
			@else
				<tr> 
					<td colspan="5"> no data found </td>
				</tr>
			@endif
			</tbody>
		</table>

		<button class="btn btn-primary btn-block hide" id="create_delivery_order_btn" onclick="submit_delivery_order()" disabled> 
			create delivery order 
		</button>
  	</div>


@endsection
