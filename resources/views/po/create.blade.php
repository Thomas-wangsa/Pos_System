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

		  <input type="hidden" class="form-control"  name="customer_uuid" value="{{$data['customer']->uuid}}">

		  <div class="form-group">
		    <label class="control-label" for="customer_name"> Customer Name :  </label>
		    <input type="text" class="form-control" value="{{$data['customer']->sales_name}}" readonly="">
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="sales_name"> Sales Name :</label>
		    <input type="text" class="form-control" value="{{$data['customer']->sales_name}}" readonly="">
		  </div>

		  <div class="form-group">
		    <label class="control-label" for="po_name"> PO Numbers :</label>
		    <input type="text" class="form-control" id="po_name" name="po_name" value="{{$data['patern_po_name']}}" disabled="">
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
		    <textarea class="form-control" rows="5" id="note" name="note"></textarea>
		  </div>

		  <div class="form-group"> 
		    <div class="col-md-6">
		      <button type="submit" class="btn btn-primary btn-block" name="po_status" value="submit"> Set Item </button>
		    </div>
		  </div>

		  <div class="form-group"> 
		    <div class="col-md-6">
		      <button type="submit" class="btn btn-warning btn-block" name="po_status" value="draft"> Set as Draft </button>
		    </div>
		  </div>
		</form>



	</div>


  
@endsection
